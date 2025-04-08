<?php

namespace App\Http\Controllers;

use App\Models\MonitoringLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Constructor.
     *
     * Since weather forecast functionality is no longer required,
     * there's no need to initialize weather API keys.
     */
    public function __construct()
    {
        // Weather API keys and related properties removed.
    }

    /**
     * Display the admin dashboard with monitoring logs data.
     */
    public function admin()
    {
        // Get monitoring logs, grouping by model and the date of the update.
        $logs = MonitoringLog::selectRaw('DATE(created_at) as date, model, COUNT(id) as update_count')
            ->groupBy('model', 'date')
            ->orderBy('date')
            ->get();

        // Prepare data for chart: unique dates and models.
        $labels = $logs->pluck('date')->unique()->values()->toArray();
        $models = $logs->pluck('model')->unique()->toArray();

        // Initialize an empty array for datasets.
        $datasets = [];

        // Create datasets for each model.
        foreach ($models as $model) {
            $datasets[] = [
                'label' => $model,
                'data' => array_map(function ($date) use ($model, $logs) {
                    $logForModel = $logs->firstWhere('model', $model);
                    return $logForModel && $logForModel->date == $date ? $logForModel->update_count : 0;
                }, $labels),
                'borderColor' => $this->getRandomColor(),
                'fill' => false,
            ];
        }

        // Pass data to the view.
        return view('admin.dashboard', compact('labels', 'datasets'));
    }

    /**
     * Display the user dashboard.
     *
     * Since weather forecast functionality is no longer needed,
     * we remove any logic that fetches or stores weather data.
     */
    public function user()
    {
        // Directly return the dashboard view without weather data.
        return view('dashboard');
    }

    /**
     * Generate a random hexadecimal color.
     *
     * @return string
     */
    private function getRandomColor()
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $letters[rand(0, 15)];
        }
        return $color;
    }
}
