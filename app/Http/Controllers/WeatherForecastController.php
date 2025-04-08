<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherForecastController extends Controller
{
    /**
     * Display the weather forecast.
     */
    public function index()
    {
        // Fetch live weather data from the Open-Meteo API
        $weatherData = $this->fetchWeatherData();

        // Pass weather data to the view without using local storage
        return view('weather_forecasts.index', compact('weatherData'));
    }

    /**
     * Fetch the weather data from the Open-Meteo API.
     */
    private function fetchWeatherData()
    {
        // Coordinates for Cabuyao, Laguna
        $latitude = 14.2667;
        $longitude = 121.0833;

        // Open-Meteo API URL: You can adjust the parameters as necessary
        $apiLink = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&daily=temperature_2m_max,temperature_2m_min,precipitation_sum&timezone=Asia/Manila&forecast_days=14";

        $response = Http::withoutVerifying()->get($apiLink);

        if ($response->successful()) {
            return $response->json();
        } else {
            // Return an empty array or handle the failure as needed
            return [];
        }
    }
}
