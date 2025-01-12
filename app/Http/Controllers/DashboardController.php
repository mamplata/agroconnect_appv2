<?php

namespace App\Http\Controllers;

use App\Models\MonitoringLog;
use App\Models\WeatherForecast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{

    protected $weatherApiKey;
    protected $locationKey;

    /**
     * Constructor to initialize API keys
     */
    public function __construct()
    {
        $this->weatherApiKey = env('VITE_WEATHER_API_KEY');
        $this->locationKey = env('VITE_WEATHER_LOCATION_KEY');
    }

    public function admin()
    {
        // Get monitoring logs, grouping by model and the date of the update
        $logs = MonitoringLog::selectRaw('DATE(created_at) as date, model, COUNT(id) as update_count')
            ->groupBy('model', 'date')
            ->orderBy('date')
            ->get();

        // Prepare data for chart
        $labels = $logs->pluck('date')->unique()->values()->toArray();  // Unique dates
        $models = $logs->pluck('model')->unique()->toArray();  // Unique models

        // Initialize an empty array for datasets
        $datasets = [];

        // Create datasets for each model
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

        // Pass data to the view
        return view('admin.dashboard', compact('labels', 'datasets'));
    }

    // Function to generate random color for each model's line
    private function getRandomColor()
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $letters[rand(0, 15)];
        }
        return $color;
    }

    /**
     * Display a listing of the resource.
     */
    public function user()
    {
        // Check if there's valid data from the latest weather record
        $existingData = WeatherForecast::latest()->first();

        // Get the current timestamp
        $timestamp = now()->getTimestamp();
        if ($existingData && $existingData->timestamp) {
            // Check if the existing data is valid (less than 2 hours old)
            if ($timestamp - $existingData->timestamp < 7200) {
                // Use existing data if valid
                $weatherData = json_decode($existingData->weather_data, true);
            } else {
                // Fetch new data from API if existing data is outdated
                $weatherData = $this->fetchWeatherData();

                // Store the new weather data
                $this->storeWeatherData($weatherData, $timestamp);
            }
        } else {
            // If no data exists, fetch new data from the API
            $weatherData = $this->fetchWeatherData();

            // Store the fetched weather data
            $this->storeWeatherData($weatherData, $timestamp);
        }

        // Pass weather data to the view
        return view('dashboard', compact('weatherData'));
    }

    /**
     * Fetch the weather data from the AccuWeather API.
     */

    private function fetchWeatherData()
    {
        // Build the API URL
        $apiLink = "https://dataservice.accuweather.com/forecasts/v1/daily/5day/{$this->locationKey}?apikey={$this->weatherApiKey}&details=true&metric=true";

        // Fetch the data from the API with SSL verification turned off
        $response = Http::withoutVerifying()->get($apiLink);

        // Check if the request was successful
        if ($response->successful()) {
            return $response->json();
        } else {
            // Handle API failure
            return [];
        }
    }

    /**
     * Store the weather data into the database.
     */
    private function storeWeatherData($weatherData, $timestamp)
    {
        WeatherForecast::create([
            'location_key' => $this->locationKey,  // You can include the location key if needed
            'weather_data' => json_encode($weatherData),
            'timestamp' => $timestamp,
        ]);
    }
}
