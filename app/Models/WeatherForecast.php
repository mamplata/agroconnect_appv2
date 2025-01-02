<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_key',
        'weather_data',
        'timestamp',
    ];

    protected $casts = [
        'weather_data' => 'array', // Cast JSON data to an array
        'timestamp' => 'integer', // Cast timestamp to integer
    ];
}
