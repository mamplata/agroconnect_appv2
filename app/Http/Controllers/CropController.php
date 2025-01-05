<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CropController extends Controller
{

    public function trends(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $crops = Crop::query()
            ->with('author') // Eager load the author relationship
            ->when($search, function ($query) use ($search) {
                $query->where('crops.cropName', 'like', "%$search%") // Explicitly specify the table
                    ->orWhere('crops.variety', 'like', "%$search%"); // Explicitly specify the table
            })
            ->when($type, function ($query) use ($type) {
                // Make sure to specify which table the 'type' belongs to
                $query->where('crops.type', $type);
            })
            ->leftJoin('crop_reports as cr', function ($join) {
                $join->on('crops.cropName', '=', 'cr.cropName') // Join on cropName
                    ->whereRaw('cr.monthObserved = (SELECT MAX(monthObserved) FROM crop_reports WHERE crop_reports.cropName = cr.cropName)'); // Get latest month
                // If variety is available, include that as well
                if (isset($join->variety)) {
                    $join->on('crops.variety', '=', 'cr.variety');
                }
            })
            ->leftJoin('crop_reports as prev_cr', function ($join) {
                $join->on('crops.cropName', '=', 'prev_cr.cropName') // Join on cropName
                    ->whereRaw('prev_cr.monthObserved = (SELECT MAX(monthObserved) FROM crop_reports WHERE crop_reports.cropName = prev_cr.cropName AND crop_reports.monthObserved < (SELECT MAX(monthObserved) FROM crop_reports WHERE crop_reports.cropName = prev_cr.cropName))'); // Get previous month
                // If variety is available, include that as well
                if (isset($join->variety)) {
                    $join->on('crops.variety', '=', 'prev_cr.variety');
                }
            })
            ->select('crops.*', 'cr.price as latest_price', 'prev_cr.price as previous_price') // Fetch latest price and previous month's price
            ->orderBy('crops.created_at', 'desc')
            ->paginate(5);

        // Pass search and type to the pagination links
        $crops->appends(['search' => $search, 'type' => $type]);

        return view('trends.index', compact('crops', 'search', 'type'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $crops = Crop::query()
            ->with('author') // Eager load the author relationship
            ->when($search, function ($query) use ($search) {
                $query->where('cropName', 'like', "%$search%")
                    ->orWhere('variety', 'like', "%$search%");
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Preserve the search and type query parameters in the pagination links
        $crops->appends(['search' => $search, 'type' => $type]);

        return view('crops.index', compact('crops', 'search', 'type'));
    }


    public function indexAdmin(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $crops = Crop::query()
            ->with('author') // Eager load the author relationship
            ->when($search, function ($query) use ($search) {
                $query->where('cropName', 'like', "%$search%")
                    ->orWhere('variety', 'like', "%$search%");
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Preserve the search and type query parameters in the pagination links
        $crops->appends(['search' => $search, 'type' => $type]);

        return view('admin.crops.index', compact('crops', 'search', 'type'));
    }

    public function create()
    {
        return view('crops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cropName' => 'required|string|max:255',
            'variety' => 'nullable|string|max:255',
            'type' => 'required|in:Rice,Vegetables,Fruits',
            'description' => 'nullable|string',
            'planting_period' => 'nullable|string|max:255',
            'growth_duration' => 'nullable|integer',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate image
        ]);

        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('crops', 'public');
        }

        Crop::create(array_merge($request->all(), [
            'user_id' => auth()->id(), // Add the current user as the creator
            'img' => $imagePath, // Store the image path
        ]));

        return redirect()->route('crops.index')->with('status', 'Crop added successfully!')->with('status_type', 'success');
    }

    public function edit(Crop $crop)
    {
        return view('crops.edit', compact('crop'));
    }

    public function update(Request $request, Crop $crop)
    {
        $validatedData = $request->validate([
            'cropName' => 'required|string|max:255',
            'variety' => 'nullable|string|max:255',
            'type' => 'required|in:Rice,Vegetables,Fruits',
            'description' => 'nullable|string',
            'planting_period' => 'nullable|string|max:255',
            'growth_duration' => 'nullable|integer',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate image
        ]);

        // Handle the image upload if a new one is provided
        if ($request->hasFile('img')) {
            // Delete the old image if it exists
            if ($crop->img && Storage::disk('public')->exists($crop->img)) {
                Storage::disk('public')->delete($crop->img);
            }

            // Store the new image
            $imagePath = $request->file('img')->store('crops', 'public');
            $validatedData['img'] = $imagePath;
        }

        $crop->update(array_merge($validatedData, [
            'modified_by' => auth()->id(),
        ]));

        return redirect()->route('crops.index')->with('status', 'Crop updated successfully!')->with('status_type', 'success');
    }

    public function destroy(Crop $crop)
    {
        // Delete the image if it exists
        if ($crop->img && Storage::disk('public')->exists($crop->img)) {
            Storage::disk('public')->delete($crop->img);
        }

        $crop->delete();

        return redirect()->route('crops.index')->with('status', 'Crop deleted successfully!')->with('status_type', 'success');
    }
}
