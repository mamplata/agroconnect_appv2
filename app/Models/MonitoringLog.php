<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model',
        'changes',
    ];

    // Mutator to modify the 'status' before saving
    public function setChangesAttribute($value)
    {
        // Check if 'changes' is an array or a JSON string
        $changes = is_array($value) ? $value : json_decode($value, true);

        // Modify the status if it exists in changes
        if (isset($changes['status'])) {
            $changes['status'] = $changes['status'] ? 'activated' : 'deactivated';
        }

        // Save the modified changes back as a JSON string
        $this->attributes['changes'] = json_encode($changes);
    }

    // Accessor (get) to transform status when retrieving the log
    public function getChangesAttribute($value)
    {
        // Decode the changes
        $changes = json_decode($value, true);

        // If 'status' exists, modify it for display
        if (isset($changes['status'])) {
            $changes['status'] = $changes['status'] === 'activated' ? true : false;
        }

        // Return the changes as an array
        return $changes;
    }

    /**
     * Get the user (author) that created the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
