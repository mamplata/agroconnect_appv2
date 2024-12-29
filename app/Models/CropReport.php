<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropReport extends Model
{
    use HasFactory;

    // Define fillable fields
    protected $fillable = [
        'user_id',
        'modified_by',
        'cropName',
        'variety',
        'type',
        'areaPlanted',
        'productionVolume',
        'yield',
        'price',
        'monthObserved'
    ];

    /**
     * Relationship with the User model
     * A CropReport belongs to a User (creator)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the User model
     * A CropReport can be modified by a User
     */
    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    /**
     * Helper method to get the creator (author) of the crop report
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
