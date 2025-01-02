<?php

namespace App\Http\Controllers;

use App\Models\WeatherForecast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherForecastController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function index()
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
        return view('weather_forecasts.index', compact('weatherData'));
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
