<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MonitoringLog;
use Illuminate\Http\Request;

class MonitoringLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        // Fetch logs based on search term, including user name, paginate the results
        $logs = MonitoringLog::query()
            ->where('action', 'like', "%{$search}%")
            ->orWhere('model', 'like', "%{$search}%")
            ->orWhere('changes', 'like', "%{$search}%")
            // Join the users table and search by the user's name
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5);

        // Append the search parameter to the pagination links
        $logs->appends(['search' => $search]);

        // Return the view with the logs and search parameter
        return view('admin.logs.index', compact('logs', 'search'));
    }
}
