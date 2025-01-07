<?php

namespace App\Http\Controllers;

use App\Models\DamageReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DamageReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $damageType = $request->input('damageType'); // New filter for damage type
        $sortBy = $request->input('sortBy', 'created_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $damageReports = DamageReport::query()
            ->with(['user', 'modifier']) // Eager load relationships
            ->when($search, function ($query) use ($search) {
                $query->where('cropName', 'like', "%$search%")
                    ->orWhere('variety', 'like', "%$search%");
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($damageType, function ($query) use ($damageType) { // Apply damage type filter
                $query->where('damage_type', $damageType);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(5);

        // Preserve search, type, damageType, sortBy, and sortOrder in pagination links
        $damageReports->appends(['search' => $search, 'type' => $type, 'damageType' => $damageType, 'sortBy' => $sortBy, 'sortOrder' => $sortOrder]);

        return view('damage_reports.index', compact('damageReports', 'search', 'type', 'damageType', 'sortBy', 'sortOrder'));
    }


    public function indexAdmin(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');
        $damageType = $request->input('damageType'); // New filter for damage type
        $sortBy = $request->input('sortBy', 'created_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $damageReports = DamageReport::query()
            ->with(['user', 'modifier']) // Eager load relationships
            ->when($search, function ($query) use ($search) {
                $query->where('cropName', 'like', "%$search%")
                    ->orWhere('variety', 'like', "%$search%");
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($damageType, function ($query) use ($damageType) { // Apply damage type filter
                $query->where('damage_type', $damageType);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(5);

        // Preserve search, type, damageType, sortBy, and sortOrder in pagination links
        $damageReports->appends(['search' => $search, 'type' => $type, 'damageType' => $damageType, 'sortBy' => $sortBy, 'sortOrder' => $sortOrder]);

        return view('admin.damage_reports.index', compact('damageReports', 'search', 'type', 'damageType', 'sortBy', 'sortOrder'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('damage_reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'crop_name' => 'required|string|max:255',
            'variety' => 'required|string|max:255',
            'type' => 'required|in:Vegetables,Fruits,Rice',
            'damage_type' => 'required|in:Natural Disaster,Pest,Disease',
            'natural_disaster_type' => 'nullable|string|max:255',
            'damage_name' => 'nullable|string|max:255',
            'area_planted' => 'required|numeric|min:0',
            'area_affected' => 'required|numeric|min:0',
            'monthObserved' => 'required|date_format:Y-m',
        ]);

        // Format the monthObserved to 'YYYY-MM' if it's a valid date
        $formattedMonthObserved = \Carbon\Carbon::createFromFormat('Y-m', $request->monthObserved)->format('Y-m');

        DamageReport::create(array_merge($request->all(), [
            'monthObserved' => $formattedMonthObserved,  // Store the formatted value
            'user_id' => auth()->id(),  // Add the current user as the creator
        ]));

        return redirect()->route('damage_reports.index')->with([
            'status' => 'Damage report added successfully!',
            'status_type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DamageReport $damageReport)
    {
        return view('damage_reports.edit', compact('damageReport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DamageReport $damageReport)
    {
        $validatedData = $request->validate([
            'crop_name' => 'required|string|max:255',
            'variety' => 'required|string|max:255',
            'type' => 'required|in:Vegetables,Fruits,Rice',
            'damage_type' => 'required|in:Natural Disaster,Pest,Disease',
            'natural_disaster_type' => 'nullable|string|max:255',
            'damage_name' => 'nullable|string|max:255',
            'area_planted' => 'required|numeric|min:0',
            'area_affected' => 'required|numeric|min:0',
            'monthObserved' => 'required|date_format:Y-m',
        ]);


        // If the validation passes, update the crop report
        $damageReport->update(array_merge($validatedData, [
            'modified_by' => auth()->id(),  // Store the user ID of the person modifying the record
        ]));


        return redirect()->route('damage_reports.index')->with([
            'status' => 'Damage report updated successfully!',
            'status_type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DamageReport $damageReport)
    {
        $damageReport->delete();

        return redirect()->route('damage_reports.index')->with([
            'status' => 'Damage report deleted successfully!',
            'status_type' => 'success',
        ]);
    }
}
