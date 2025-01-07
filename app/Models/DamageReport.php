<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'modified_by',
        'crop_name',
        'variety',
        'type',
        'damage_type',   // Natural Disaster, Pest, Disease
        'natural_disaster_type',  // Type of disaster, if applicable
        'damage_name', // Name of the disaster, if applicable
        'area_planted',   // Full area planted (ha)
        'area_affected',  // Affected area (ha)
        'monthObserved', // Month when the damage occurred
    ];

    /**
     * Relationship with the User model
     * A CropReport belongs to a User (creator)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optionally, you can define relationships with other models, e.g., User (Author/Modifier)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
