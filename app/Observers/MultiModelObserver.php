<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Crop;
use App\Models\MonitoringLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MultiModelObserver
{
    public function created($model)
    {
        $this->logAction('Created', $model);
    }

    public function updated($model)
    {
        $this->logAction('Updated', $model);
    }

    public function deleted($model)
    {
        if ($model instanceof User) {
            $this->logUserAction('Deleted', $model);
        } else {
            $this->logAction('Deleted', $model);
        }
    }

    private function logAction($action, $model)
    {
        $userId = $model instanceof User ? $model->id : Auth::id();

        // Get detailed changes
        $changes = $model->getChanges();

        // Log only actual changes to the model
        $changeDetails = !empty($changes) ? json_encode($changes) : 'No changes';

        MonitoringLog::create([
            'user_id' => $userId,
            'action' => $action,
            'model' => get_class($model),
            'changes' => $changeDetails,  // Log detailed changes as a JSON string
        ]);

        // Optionally log to Laravel log for debugging purposes
        Log::info("Action: {$action} | Model: " . get_class($model) . " | Changes: {$changeDetails}");
    }

    private function logUserAction($action, $model)
    {
        // For user deletion, log with a specific message
        $changeDetails = 'User deleted';

        MonitoringLog::create([
            'user_id' => null,  // No user ID for deleted user
            'action' => $action,
            'model' => get_class($model),
            'changes' => $changeDetails,
        ]);

        // Optionally log to Laravel log for debugging purposes
        Log::info("Action: {$action} | Model: " . get_class($model) . " | Changes: {$changeDetails}");
    }
}
