<?php

namespace App\Http\Controllers;

use App\Models\DamageReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DamageReportController extends Controller
{
    // Display the list of damage reports
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $type = $request->input('type', '');
        $sortBy = $request->input('sortBy', 'created_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $damageReports = DamageReport::query()
            ->where('crop_name', 'like', "%{$search}%")
            ->where(function ($query) use ($type) {
                if ($type) {
                    $query->where('type', $type);
                }
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);

        return view('damage_reports.index', compact('damageReports', 'search', 'type', 'sortBy', 'sortOrder'));
    }

    // Display the list of damage reports
    public function indexAdmin(Request $request)
    {
        $search = $request->input('search', '');
        $type = $request->input('type', '');
        $sortBy = $request->input('sortBy', 'created_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $damageReports = DamageReport::query()
            ->where('crop_name', 'like', "%{$search}%")
            ->where(function ($query) use ($type) {
                if ($type) {
                    $query->where('type', $type);
                }
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);

        return view('admin.damage_reports.index', compact('damageReports', 'search', 'type', 'sortBy', 'sortOrder'));
    }

    // Show the form to create a new damage report
    public function create()
    {
        return view('damage_reports.create');
    }

    // Store a new damage report
    public function store(Request $request)
    {
        $validated = $request->validate([
            'crop_name' => 'required|string',
            'variety' => 'required|string',
            'type' => 'required|in:Rice,Vegetables,Fruits',
            'damage_type' => 'required|in:Natural Disaster,Pest,Disease',
            'natural_disaster_type' => 'nullable|string',
            'disaster_name' => 'nullable|string',
            'pest_or_disease' => 'nullable|string',
            'area_planted' => 'required|numeric',
            'area_affected' => 'required|numeric',
            'month_observed' => 'required|date_format:Y-m',
        ]);

        // Store the damage report
        $damageReport = DamageReport::create([
            'crop_name' => $validated['crop_name'],
            'variety' => $validated['variety'],
            'type' => $validated['type'],
            'damage_type' => $validated['damage_type'],
            'natural_disaster_type' => $validated['damage_type'] == 'Natural Disaster' ? $validated['natural_disaster_type'] : null,
            'disaster_name' => $validated['damage_type'] == 'Natural Disaster' ? $validated['disaster_name'] : null,
            'pest_or_disease' => $validated['damage_type'] == 'Pest' || $validated['damage_type'] == 'Disease' ? $validated['pest_or_disease'] : null,
            'area_planted' => $validated['area_planted'],
            'area_affected' => $validated['area_affected'],
            'month_observed' => Carbon::createFromFormat('Y-m', $validated['month_observed']),
            'author_id' => auth()->id(),  // Assuming authentication is in place
        ]);

        return redirect()->route('damage_reports.index')->with('status', 'Damage report created successfully.');
    }

    // Show the form to edit an existing damage report
    public function edit(DamageReport $damageReport)
    {
        return view('damage_reports.edit', compact('damageReport'));
    }

    // Update an existing damage report
    public function update(Request $request, DamageReport $damageReport)
    {
        $validated = $request->validate([
            'crop_name' => 'required|string',
            'variety' => 'required|string',
            'type' => 'required|in:Rice,Vegetables,Fruits',
            'damage_type' => 'required|in:Natural Disaster,Pest,Disease',
            'natural_disaster_type' => 'nullable|string',
            'disaster_name' => 'nullable|string',
            'pest_or_disease' => 'nullable|string',
            'area_planted' => 'required|numeric',
            'area_affected' => 'required|numeric',
            'month_observed' => 'required|date_format:Y-m',
        ]);

        $damageReport->update([
            'crop_name' => $validated['crop_name'],
            'variety' => $validated['variety'],
            'type' => $validated['type'],
            'damage_type' => $validated['damage_type'],
            'natural_disaster_type' => $validated['damage_type'] == 'Natural Disaster' ? $validated['natural_disaster_type'] : null,
            'disaster_name' => $validated['damage_type'] == 'Natural Disaster' ? $validated['disaster_name'] : null,
            'pest_or_disease' => $validated['damage_type'] == 'Pest' || $validated['damage_type'] == 'Disease' ? $validated['pest_or_disease'] : null,
            'area_planted' => $validated['area_planted'],
            'area_affected' => $validated['area_affected'],
            'month_observed' => Carbon::createFromFormat('Y-m', $validated['month_observed']),
            'modifier_id' => auth()->id(),  // Assuming authentication is in place
        ]);

        return redirect()->route('damage_reports.index')->with('status', 'Damage report updated successfully.');
    }

    // Delete a damage report
    public function destroy(DamageReport $damageReport)
    {
        $damageReport->delete();
        return redirect()->route('damage_reports.index')->with('status', 'Damage report deleted successfully.');
    }
}
