<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CropController extends Controller
{
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
