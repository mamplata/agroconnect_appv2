<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index()
    {
        $crops = Crop::all();
        return view('crops.index', compact('crops'));
    }

    public function create()
    {
        return view('crops.create');
    }

    public function store(Request $request)
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
