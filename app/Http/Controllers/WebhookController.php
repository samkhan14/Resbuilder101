<?php

namespace App\Http\Controllers;

use App\Models\SyncLog;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{

    /**
     * Handle n8n webhook responses for resume sync
     */
    public function handleN8nResponse(Request $request)
    {
        try {
            $data = $request->all();

            // Validate required fields
            if (!isset($data['sync_log_id']) || !isset($data['status'])) {
                return response()->json(['error' => 'Missing required fields'], 400);
            }

            $syncLogId = $data['sync_log_id'];
            $status = $data['status'];

            // Find the sync log
            $syncLog = SyncLog::find($syncLogId);
            if (!$syncLog) {
                return response()->json(['error' => 'Sync log not found'], 404);
            }

            // Update sync log based on status
            switch ($status) {
                case 'success':
                    $this->handleSuccessResponse($syncLog, $data);
                    break;
                case 'failed':
                    $this->handleFailedResponse($syncLog, $data);
                    break;
                case 'processing':
                    $this->handleProcessingResponse($syncLog, $data);
                    break;
                default:
                    return response()->json(['error' => 'Invalid status'], 400);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Handle successful sync response
     */
    protected function handleSuccessResponse(SyncLog $syncLog, array $data)
    {
        $executionTime = $data['execution_time'] ?? null;
        $responseData = $data['response_data'] ?? [];
        $botLogs = $data['bot_logs'] ?? [];

        // Update sync log
        $syncLog->update([
            'status' => 'success',
            'response_data' => $responseData,
            'completed_at' => now(),
            'execution_time' => $executionTime,
        ]);

        // Update bot logs if provided
        if (!empty($botLogs)) {
            $syncLog->update(['bot_logs' => $botLogs]);
        }

        // Log activity
        ActivityLog::create([
            'description' => "Resume '{$syncLog->resume->title}' successfully synced to {$syncLog->platform}",
            'subject_type' => get_class($syncLog->resume),
            'subject_id' => $syncLog->resume->id,
            'causer_type' => get_class($syncLog->user),
            'causer_id' => $syncLog->user->id,
            'event' => 'resume_sync_completed',
            'properties' => [
                'platform' => $syncLog->platform,
                'execution_time' => $executionTime,
                'sync_log_id' => $syncLog->id
            ],
        ]);

        // Update resume last synced timestamp
        $syncLog->resume->update(['last_synced_at' => now()]);
    }

    /**
     * Handle failed sync response
     */
    protected function handleFailedResponse(SyncLog $syncLog, array $data)
    {
        $errorMessage = $data['error_message'] ?? 'Unknown error occurred';
        $botLogs = $data['bot_logs'] ?? [];

        // Update sync log
        $syncLog->update([
            'status' => 'failed',
            'response_data' => $data['response_data'] ?? null,
            'error_message' => $errorMessage,
            'completed_at' => now(),
        ]);

        // Update bot logs if provided
        if (!empty($botLogs)) {
            $syncLog->update(['bot_logs' => $botLogs]);
        }

        // Log activity
        ActivityLog::create([
            'description' => "Resume '{$syncLog->resume->title}' sync failed on {$syncLog->platform}: {$errorMessage}",
            'subject_type' => get_class($syncLog->resume),
            'subject_id' => $syncLog->resume->id,
            'causer_type' => get_class($syncLog->user),
            'causer_id' => $syncLog->user->id,
            'event' => 'resume_sync_failed',
            'properties' => [
                'platform' => $syncLog->platform,
                'error' => $errorMessage,
                'sync_log_id' => $syncLog->id
            ],
        ]);
    }

    /**
     * Handle processing sync response
     */
    protected function handleProcessingResponse(SyncLog $syncLog, array $data)
    {
        $responseData = $data['response_data'] ?? [];
        $botLogs = $data['bot_logs'] ?? [];

        // Update sync log
        $syncLog->update([
            'status' => 'processing',
            'response_data' => $responseData,
        ]);

        // Update bot logs if provided
        if (!empty($botLogs)) {
            $syncLog->update(['bot_logs' => $botLogs]);
        }

        // Log activity
        ActivityLog::create([
            'description' => "Resume '{$syncLog->resume->title}' sync processing on {$syncLog->platform}",
            'subject_type' => get_class($syncLog->resume),
            'subject_id' => $syncLog->resume->id,
            'causer_type' => get_class($syncLog->user),
            'causer_id' => $syncLog->user->id,
            'event' => 'resume_sync_processing',
            'properties' => [
                'platform' => $syncLog->platform,
                'sync_log_id' => $syncLog->id
            ],
        ]);
    }

    /**
     * Handle manual sync required response
     */
    public function handleManualSyncRequired(Request $request)
    {
        try {
            $data = $request->all();

            if (!isset($data['sync_log_id'])) {
                return response()->json(['error' => 'Missing sync_log_id'], 400);
            }

            $syncLog = SyncLog::find($data['sync_log_id']);
            if (!$syncLog) {
                return response()->json(['error' => 'Sync log not found'], 404);
            }

            // Update sync log
            $syncLog->update([
                'status' => 'manual_required',
                'response_data' => $data['response_data'] ?? null,
                'error_message' => $data['reason'] ?? 'Manual intervention required',
                'completed_at' => now(),
            ]);

            // Log activity
            ActivityLog::create([
                'description' => "Manual sync required for resume '{$syncLog->resume->title}' on {$syncLog->platform}",
                'subject_type' => get_class($syncLog->resume),
                'subject_id' => $syncLog->resume->id,
                'causer_type' => get_class($syncLog->user),
                'causer_id' => $syncLog->user->id,
                'event' => 'resume_sync_manual_required',
                'properties' => [
                    'platform' => $syncLog->platform,
                    'reason' => $data['reason'] ?? 'Manual intervention required',
                    'sync_log_id' => $syncLog->id
                ],
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Manual sync webhook failed', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
