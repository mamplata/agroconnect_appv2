<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\CropReport;
use Illuminate\Http\Request;

class CropReportController extends Controller
{

    public function trendsShow(Request $request, $cropName, $variety)
    {
        // Start the query to retrieve the price data for the specified crop name and variety
        $query = CropReport::where('cropName', $cropName)
            ->where('variety', $variety)
            ->orderBy('monthObserved'); // Sort by monthObserved for easier comparison

        // Get the price data
        $prices = $query->paginate(5); // Add pagination here

        // Transform to calculate status and format the date before applying sorting or filtering
        $prices->getCollection()->transform(function ($item, $key) use ($prices) {
            $previousPrice = $key > 0 ? $prices[$key - 1]->price : null;

            if ($previousPrice) {
                // Compare current price with the previous one
                if ($item->price > $previousPrice) {
                    $item->status = 'Up';
                    $item->statusIcon = 'fas fa-arrow-up text-success'; // FontAwesome icon for up
                } elseif ($item->price < $previousPrice) {
                    $item->status = 'Down';
                    $item->statusIcon = 'fas fa-arrow-down text-danger'; // FontAwesome icon for down
                } else {
                    $item->status = 'No Change';
                    $item->statusIcon = 'fas fa-minus text-secondary'; // FontAwesome icon for no change
                }
            } else {
                // For the first price entry, assume 'No Change' or 'Up' as initial state
                $item->status = 'No Change';
                $item->statusIcon = 'fas fa-minus text-secondary';
            }

            // Add formatted date
            $item->date = \Carbon\Carbon::parse($item->monthObserved)->format('F Y'); // Format the date as "January 2024"

            return $item;
        });

        // Apply the date filter using min, max, or between logic
        if ($request->has('start_date') || $request->has('end_date')) {
            // Ensure date format is 'F Y' and parse correctly, but only if provided
            $startDate = null;
            if ($request->has('start_date') && $request->start_date) {
                $startDate = \Carbon\Carbon::parse($request->start_date)->startOfMonth();
            }

            $endDate = null;
            if ($request->has('end_date') && $request->end_date) {
                $endDate = \Carbon\Carbon::parse($request->end_date)->endOfMonth();
            }

            $prices = $prices->filter(function ($item) use ($startDate, $endDate) {
                // Parse the item's monthObserved as a Carbon instance
                $itemDate = \Carbon\Carbon::parse($item->date);

                // Apply filter logic for start_date and end_date
                if ($startDate && !$endDate) {
                    // If only start_date is provided, filter using 'min' logic: dates >= start_date
                    return $itemDate >= $startDate;
                } elseif (!$startDate && $endDate) {
                    // If only end_date is provided, filter using 'max' logic: dates <= end_date
                    return $itemDate <= $endDate;
                } elseif ($startDate && $endDate) {
                    // If both start_date and end_date are provided, filter using 'between' logic
                    return $itemDate >= $startDate && $itemDate <= $endDate;
                }

                // No filtering if neither start_date nor end_date is provided
                return true;
            });
        }

        // Check if sorting direction for price is provided and apply it
        if ($request->has('price') && in_array($request->price, ['asc', 'desc'])) {
            $prices = $prices->sortBy(function ($item) {
                return $item->price;
            });

            // Apply descending order if required
            if ($request->price == 'desc') {
                $prices = $prices->reverse();
            }
        }

        return view('trends.price', compact('prices', 'cropName', 'variety'));
    }

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

        // Preserve search, type, sortBy, and sortOrder in pagination links
        $cropReports->appends(['search' => $search, 'type' => $type, 'sortBy' => $sortBy, 'sortOrder' => $sortOrder]);

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

        // Preserve search, type, sortBy, and sortOrder in pagination links
        $cropReports->appends(['search' => $search, 'type' => $type, 'sortBy' => $sortBy, 'sortOrder' => $sortOrder]);

        return view('admin.crop_reports.index', compact('cropReports', 'search', 'type', 'sortBy', 'sortOrder'));
    }

    public function stats(Request $request, $cropName, $variety)
    {
        // Fetch data for the specified cropName and variety
        $data = CropReport::where('cropName', $cropName)
            ->where('variety', $variety)
            ->orderBy('monthObserved')
            ->get();

        // Format the data for Chart.js
        $chartData = [
            'labels' => $data->pluck('monthObserved')->map(function ($date) {
                return \Carbon\Carbon::createFromFormat('Y-m', $date)->format('F Y');
            }),
            'datasets' => [
                [
                    'label' => 'Area Planted (ha)',
                    'data' => $data->pluck('areaPlanted'),
                    'borderColor' => 'rgba(153, 102, 255, 1)',
                    'yAxisID' => 'y1',
                ],
                [
                    'label' => 'Production Volume (MT)',
                    'data' => $data->pluck('productionVolume'),
                    'borderColor' => 'rgba(255, 159, 64, 1)',
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Yield (MT/ha)',
                    'data' => $data->pluck('yield'),
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'yAxisID' => 'y1',
                ],
                [
                    'label' => 'Price',
                    'data' => $data->pluck('price'),
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'yAxisID' => 'y2',
                ],
                [
                    'label' => 'Price Income',
                    'data' => $data->map(function ($item) {
                        return $item->productionVolume * $item->price;
                    }),
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'yAxisID' => 'y2',
                ],
            ],
        ];

        return view('trends.stats', compact('chartData', 'cropName', 'variety'));
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
