<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInformation extends Model
{
    use HasFactory;

    // Define the fillable properties (columns that are mass-assignable)
    protected $fillable = [
        'crop_id',      // The crop the file is associated with
        'fileHolder',   // The file details (encoded as JSON)
    ];

    // Define the relationship between AdditionalInformation and Crop
    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
