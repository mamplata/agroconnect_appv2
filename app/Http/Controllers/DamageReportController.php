<?php

namespace App\Http\Controllers;

use App\Models\DamageReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DamageReportController extends Controller
{

    public function pests()
    {
        // Fetch all pest damage data where area_planted and area_affected are not zero
        $data = DamageReport::where('damage_type', 'Pest')
            ->where('area_planted', '>', 0)
            ->where('area_affected', '>', 0)
            ->orderBy('monthObserved')
            ->get();

        // Group data by cropName and variety, replacing "N/A" or null with an empty string
        $groupedData = $data->groupBy(function ($item) {
            $variety = $item->variety;
            // Replace "N/A" or null with an empty string
            $variety = ($variety === 'N/A' || $variety === null) ? '' : $variety;
            return $item->cropName . ' - ' . $variety;
        });

        // Prepare datasets for grouped stacked bar chart
        $groupedChartData = [
            'labels' => $data->pluck('monthObserved')
                ->map(function ($date) {
                    return \Carbon\Carbon::createFromFormat('Y-m', $date)->format('F Y');
                })
                ->unique()
                ->values(),
            'datasets' => [],
        ];

        // Prepare data for the pie chart (summed area_affected per damage_name)
        $damageSummary = $data->groupBy('damage_name')->map(function ($group) {
            return $group->sum('area_affected');
        });

        $pieChartData = [
            'labels' => $damageSummary->keys(),
            'data' => $damageSummary->values(),
        ];

        foreach ($groupedData as $groupKey => $group) {
            // Group by damage name to stack values within the same crop variety
            $damageGroups = $group->groupBy('damage_name');

            foreach ($damageGroups as $damageName => $damageGroup) {
                $datasetKey = $groupKey . ' (' . $damageName . ')';
                $color = 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ',';

                // Add stacked dataset
                $groupedChartData['datasets'][] = [
                    'label' => $datasetKey,
                    'data' => $groupedChartData['labels']->map(function ($month) use ($damageGroup) {
                        return $damageGroup->where('monthObserved', \Carbon\Carbon::parse($month)->format('Y-m'))->sum('area_affected');
                    }),
                    'backgroundColor' => $color . ' 0.8)', // Random color with opacity
                    'borderColor' => $color . ' 1)',
                    'borderWidth' => 1,
                    'stack' => $groupKey, // Use crop variety as stack key
                    'areaPlantedData' => $groupedChartData['labels']->map(function ($month) use ($damageGroup) {
                        return $damageGroup->where('monthObserved', \Carbon\Carbon::parse($month)->format('Y-m'))->sum('area_planted');
                    }),
                ];
            }
        }

        return view('damages.pests', compact('groupedChartData', 'pieChartData'));
    }

    public function diseases()
    {
        // Fetch all diseases damage data where area_planted and area_affected are not zero
        $data = DamageReport::where('damage_type', 'Disease')
            ->where('area_planted', '>', 0)
            ->where('area_affected', '>', 0)
            ->orderBy('monthObserved')
            ->get();

        // Group data by cropName and variety, replacing "N/A" or null with an empty string
        $groupedData = $data->groupBy(function ($item) {
            $variety = $item->variety;
            // Replace "N/A" or null with an empty string
            $variety = ($variety === 'N/A' || $variety === null) ? '' : $variety;
            return $item->cropName . ' - ' . $variety;
        });

        // Prepare datasets for grouped stacked bar chart
        $groupedChartData = [
            'labels' => $data->pluck('monthObserved')
                ->map(function ($date) {
                    return \Carbon\Carbon::createFromFormat('Y-m', $date)->format('F Y');
                })
                ->unique()
                ->values(),
            'datasets' => [],
        ];

        // Prepare data for the pie chart (summed area_affected per damage_name)
        $damageSummary = $data->groupBy('damage_name')->map(function ($group) {
            return $group->sum('area_affected');
        });

        $pieChartData = [
            'labels' => $damageSummary->keys(),
            'data' => $damageSummary->values(),
        ];

        foreach ($groupedData as $groupKey => $group) {
            // Group by damage name to stack values within the same crop variety
            $damageGroups = $group->groupBy('damage_name');

            foreach ($damageGroups as $damageName => $damageGroup) {
                $datasetKey = $groupKey . ' (' . $damageName . ')';
                $color = 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ',';

                // Add stacked dataset
                $groupedChartData['datasets'][] = [
                    'label' => $datasetKey,
                    'data' => $groupedChartData['labels']->map(function ($month) use ($damageGroup) {
                        return $damageGroup->where('monthObserved', \Carbon\Carbon::parse($month)->format('Y-m'))->sum('area_affected');
                    }),
                    'backgroundColor' => $color . ' 0.8)', // Random color with opacity
                    'borderColor' => $color . ' 1)',
                    'borderWidth' => 1,
                    'stack' => $groupKey, // Use crop variety as stack key
                    'areaPlantedData' => $groupedChartData['labels']->map(function ($month) use ($damageGroup) {
                        return $damageGroup->where('monthObserved', \Carbon\Carbon::parse($month)->format('Y-m'))->sum('area_planted');
                    }),
                ];
            }
        }

        return view('damages.diseases', compact('groupedChartData', 'pieChartData'));
    }

    public function disasters()
    {
        // Fetch all disasters damage data where area_planted and area_affected are not zero
        $data = DamageReport::where('damage_type', 'Natural Disaster')
            ->where('area_planted', '>', 0)
            ->where('area_affected', '>', 0)
            ->orderBy('monthObserved')
            ->get();

        // Group data by cropName and variety, replacing "N/A" or null with an empty string
        $groupedData = $data->groupBy(function ($item) {
            $variety = $item->variety;
            // Replace "N/A" or null with an empty string
            $variety = ($variety === 'N/A' || $variety === null) ? '' : $variety;
            return $item->cropName . ' - ' . $variety;
        });

        // Prepare datasets for grouped stacked bar chart
        $groupedChartData = [
            'labels' => $data->pluck('monthObserved')
                ->map(function ($date) {
                    return \Carbon\Carbon::createFromFormat('Y-m', $date)->format('F Y');
                })
                ->unique()
                ->values(),
            'datasets' => [],
        ];

        // Prepare data for the pie chart (summed area_affected per natural_disaster_type)
        $damageSummary = $data->groupBy('natural_disaster_type')->map(function ($group) {
            return $group->sum('area_affected');
        });

        $pieChartData = [
            'labels' => $damageSummary->keys(),
            'data' => $damageSummary->values(),
        ];

        foreach ($groupedData as $groupKey => $group) {
            // Group by damage name to stack values within the same crop variety
            $damageGroups = $group->groupBy('natural_disaster_type');

            foreach ($damageGroups as $damageName => $damageGroup) {
                $datasetKey = $groupKey . ' (' . $damageName . ')';
                $color = 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ',';

                // Add stacked dataset
                $groupedChartData['datasets'][] = [
                    'label' => $datasetKey,
                    'data' => $groupedChartData['labels']->map(function ($month) use ($damageGroup) {
                        return $damageGroup->where('monthObserved', \Carbon\Carbon::parse($month)->format('Y-m'))->sum('area_affected');
                    }),
                    'backgroundColor' => $color . ' 0.8)', // Random color with opacity
                    'borderColor' => $color . ' 1)',
                    'borderWidth' => 1,
                    'stack' => $groupKey, // Use crop variety as stack key
                    'areaPlantedData' => $groupedChartData['labels']->map(function ($month) use ($damageGroup) {
                        return $damageGroup->where('monthObserved', \Carbon\Carbon::parse($month)->format('Y-m'))->sum('area_planted');
                    }),
                ];
            }
        }

        return view('damages.disasters', compact('groupedChartData', 'pieChartData'));
    }
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
            'cropName' => 'required|string|max:255',
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
            'cropName' => 'required|string|max:255',
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
