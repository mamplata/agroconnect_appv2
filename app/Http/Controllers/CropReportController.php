<?php

namespace App\Http\Controllers;

use App\Models\CropReport;
use Illuminate\Http\Request;

class CropReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $sortBy = $request->input('sortBy', 'created_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $cropReports = CropReport::query()
            ->with(['user', 'modifier']) // Eager load relationships
            ->when($search, function ($query) use ($search) {
                $query->where('cropName', 'like', "%$search%")
                    ->orWhere('variety', 'like', "%$search%");
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(5);

        return view('crop_reports.index', compact('cropReports', 'search', 'type', 'sortBy', 'sortOrder'));
    }

    public function indexAdmin(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $sortBy = $request->input('sortBy', 'created_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $cropReports = CropReport::query()
            ->with(['user', 'modifier']) // Eager load relationships
            ->when($search, function ($query) use ($search) {
                $query->where('cropName', 'like', "%$search%")
                    ->orWhere('variety', 'like', "%$search%");
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(5);

        return view('admin.crop_reports.index', compact('cropReports', 'search', 'type', 'sortBy', 'sortOrder'));
    }



    public function create()
    {
        return view('crop_reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cropName' => 'required|string|max:255',
            'variety' => 'nullable|string|max:255',
            'type' => 'required|in:Rice,Vegetables,Fruits',
            'areaPlanted' => 'required|numeric|min:0',
            'productionVolume' => 'required|numeric|min:0',
            'yield' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'monthObserved' => 'required|date_format:Y-m',  // Validate for 'YYYY-MM' format
        ]);

        // Format the monthObserved to 'YYYY-MM' if it's a valid date
        $formattedMonthObserved = \Carbon\Carbon::createFromFormat('Y-m', $request->monthObserved)->format('Y-m');

        CropReport::create(array_merge($request->all(), [
            'monthObserved' => $formattedMonthObserved,  // Store the formatted value
            'user_id' => auth()->id(),  // Add the current user as the creator
        ]));

        return redirect()->route('crop_reports.index')
            ->with('status', 'Crop report added successfully!')
            ->with('status_type', 'success');
    }


    public function edit(CropReport $cropReport)
    {
        return view('crop_reports.edit', compact('cropReport'));
    }

    public function update(Request $request, CropReport $cropReport)
    {
        $validatedData = $request->validate([
            'cropName' => 'required|string|max:255',
            'variety' => 'nullable|string|max:255',
            'type' => 'required|in:Rice,Vegetables,Fruits',
            'areaPlanted' => 'required|numeric|min:0',
            'productionVolume' => 'required|numeric|min:0',
            'yield' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'monthObserved' => 'required|date_format:Y-m',  // Validate for 'YYYY-MM' format
        ]);

        // If the validation passes, update the crop report
        $cropReport->update(array_merge($validatedData, [
            'modified_by' => auth()->id(),  // Store the user ID of the person modifying the record
        ]));

        // Redirect to the crop reports index page with a success message
        return redirect()->route('crop_reports.index')->with('status', 'Crop report updated successfully!')->with('status_type', 'success');
    }


    public function destroy(CropReport $cropReport)
    {
        $cropReport->delete();

        return redirect()->route('crop_reports.index')->with('status', 'Crop report deleted successfully!')->with('status_type', 'success');
    }
}
