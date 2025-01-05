<?php

namespace App\Http\Controllers;

use App\Models\AdditionalInformation;
use App\Models\Crop;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdditionalInformationController extends Controller
{

    public function showInformation($crop_id)
    {
        // Fetch crop data for Squash (assuming you have a method to get the crop by ID)
        $crop = Crop::findOrFail($crop_id);

        // Fetch additional information related to the Squash crop, with author details, pagination, and sorted by created_at
        $additionalInformation = AdditionalInformation::where('crop_id', $crop_id)
            ->with('author') // Eager load the author relationship
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->paginate(5);

        // Return the view with the crop and additional information
        return view('trends.info', compact('crop', 'additionalInformation'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index($crop_id)
    {
        // Fetch additional information related to the specific crop, with author details, pagination, and sorted by created_at
        $additionalInformation = AdditionalInformation::where('crop_id', $crop_id)
            ->with('author') // Eager load the user relationship
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->paginate(5);

        // Fetch the crop data if needed for display
        $crop = Crop::findOrFail($crop_id);
        session(['crop' => $crop]);

        return view('crops.additional_information', compact('crop', 'additionalInformation'));
    }

    public function indexAdmin($crop_id)
    {
        // Fetch additional information related to the specific crop, with author details, pagination, and sorted by created_at
        $additionalInformation = AdditionalInformation::where('crop_id', $crop_id)
            ->with('author') // Eager load the user relationship
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->paginate(5);

        // Fetch the crop data if needed for display
        $crop = Crop::findOrFail($crop_id);
        session(['crop' => $crop]);

        return view('admin.crops.additional_information', compact('crop', 'additionalInformation'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($crop)
    {
        return view('crops.upload', compact('crop'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the file (max 10 MB)
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx,txt|max:10240', // 10MB
            'crop_id' => 'required|exists:crops,id', // Ensure crop_id exists in the crops table
        ]);

        try {
            // Handle the file upload
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');

            // Store the file details in the database
            AdditionalInformation::create([
                'crop_id' => $request->crop_id, // Save crop_id to associate the file with a crop
                'user_id' => auth()->id(), // Save the ID of the authenticated user as the author
                'fileHolder' => json_encode([
                    'originalName' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ]),
            ]);

            // Redirect back to the upload page for this crop
            return redirect()->route('upload.index', ['crop' => $request->crop_id])->with([
                'status' => 'File uploaded successfully.',
                'status_type' => 'success',
            ]);
        } catch (\Exception $e) {
            // Set error message if something goes wrong (e.g., file storage issues)
            return redirect()->route('upload.index', ['crop' => $request->crop_id])->with([
                'status' => 'Error uploading file. Please try again.',
                'status_type' => 'danger',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($crop_id, AdditionalInformation $additionalInformation)
    {
        // Check if the AdditionalInformation belongs to the specified crop_id
        if ($additionalInformation->crop_id != $crop_id) {
            return redirect()->route('upload.index', ['crop_id' => $crop_id])
                ->with('status', 'Invalid request. File does not belong to this crop.')
                ->with('status_type', 'danger');
        }

        // Decode the fileHolder JSON string
        $fileHolder = json_decode($additionalInformation->fileHolder, true);

        // Check if the path exists in the decoded data
        if (isset($fileHolder['path']) && Storage::exists('public/' . $fileHolder['path'])) {
            Storage::delete('public/' . $fileHolder['path']);
        }

        // Delete the AdditionalInformation record
        $additionalInformation->delete();

        // Redirect with success message
        return redirect()->route('upload.index', ['crop' => $crop_id])
            ->with('status', 'File deleted successfully!')
            ->with('status_type', 'success');
    }
}
