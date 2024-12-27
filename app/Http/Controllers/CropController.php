<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $crops = Crop::query()
            ->when($search, function ($query) use ($search) {
                $query->where('cropName', 'like', "%$search%")
                    ->orWhere('variety', 'like', "%$search%");
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->orderBy('created_at', 'desc') // Sort by latest created_at
            ->paginate(10);

        return view('crops.index', compact('crops', 'search', 'type'));
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
        ]);

        Crop::create(array_merge($request->all(), [
            'user_id' => auth()->id(), // Add the current user as the creator
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
        ]);

        $crop->update(array_merge($validatedData, [
            'modified_by' => auth()->id(),
        ]));

        return redirect()->route('crops.index')->with('status', 'Crop updated successfully!')->with('status_type', 'success');
    }

    public function destroy(Crop $crop)
    {
        $crop->delete();

        return redirect()->route('crops.index')->with('status', 'Crop deleted successfully!')->with('status_type', 'success');
    }

    public function upload()
    {
        return view('crops.upload');
    }

    public function storeUpload(Request $request)
    {
        // Validate the file (max 10 MB)
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx,txt|max:10240', // 10MB
        ]);

        try {
            // Handle the file upload
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');

            // Store the file details in the database
            Crop::create([
                'fileHolder' => json_encode([
                    'originalName' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ]),
            ]);

            // Set success message
            return redirect()->route('manage-crop')->with([
                'status' => 'File uploaded successfully.',
                'status_type' => 'success', // To distinguish between success and error messages
            ]);
        } catch (\Exception $e) {
            // Set error message if something goes wrong (e.g., file storage issues)
            return redirect()->route('manage-crop')->with([
                'status' => 'Error uploading file. Please try again.',
                'status_type' => 'danger', // Error message type
            ]);
        }
    }
}
