<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    // Define fillable fields
    protected $fillable = [
        'user_id',
        'cropName',
        'variety',
        'type',
        'description',
        'planting_period',
        'growth_duration',
        'modified_by'
    ];

    /**
     * Relationship with the User model
     * A Crop belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with User model for 'modified_by'
    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
