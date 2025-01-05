<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_name',
        'variety',
        'type',
        'damage_type',   // Natural Disaster, Pest, Disease
        'natural_disaster_type',  // Type of disaster, if applicable
        'disaster_name', // Name of the disaster, if applicable
        'pest_or_disease',  // Pest or disease name, if applicable
        'area_planted',   // Full area planted (ha)
        'area_affected',  // Affected area (ha)
        'month_observed', // Month when the damage occurred
    ];

    // Optionally, you can define relationships with other models, e.g., User (Author/Modifier)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modifier_id');
    }
}
