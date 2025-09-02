<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LogsController extends Controller
{

    /**
     * Display logs page
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        // Get recent activity logs for the user
        $activityLogs = ActivityLog::where('causer_type', get_class($user))
            ->where('causer_id', $user->id)
            ->latest()
            ->limit(50)
            ->get();

        // Get recent sync logs for the user
        $syncLogs = SyncLog::where('user_id', $user->id)
            ->latest()
            ->limit(50)
            ->get();

        // Get sync statistics
        $syncStats = [
            'total_syncs' => $syncLogs->count(),
            'successful_syncs' => $syncLogs->where('status', 'success')->count(),
            'failed_syncs' => $syncLogs->where('status', 'failed')->count(),
            'pending_syncs' => $syncLogs->where('status', 'pending')->count(),
            'processing_syncs' => $syncLogs->where('status', 'processing')->count(),
        ];

        return Inertia::render('Logs/Index', [
            'activityLogs' => $activityLogs,
            'syncLogs' => $syncLogs,
            'syncStats' => $syncStats,
        ]);
    }

    /**
     * Get activity logs with pagination
     */
    public function activity(Request $request)
    {
        $user = $request->user();
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 20);

        $logs = ActivityLog::where('causer_type', get_class($user))
            ->where('causer_id', $user->id)
            ->latest()
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'logs' => $logs,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $logs->count(),
            ]
        ]);
    }

    /**
     * Get sync logs with pagination
     */
    public function sync(Request $request)
    {
        $user = $request->user();
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 20);
        $platform = $request->get('platform');
        $status = $request->get('status');

        $query = SyncLog::where('user_id', $user->id)
            ->latest()
            ->limit($limit)
            ->get();

        if ($platform) {
            $query = $query->where('platform', $platform);
        }

        if ($status) {
            $query = $query->where('status', $status);
        }

        return response()->json([
            'success' => true,
            'logs' => $query,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $query->count(),
            ]
        ]);
    }
}
