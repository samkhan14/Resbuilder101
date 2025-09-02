<?php

namespace App\Http\Controllers;

use App\Models\PlatformCredential;
use App\Services\PlatformAutomationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class PlatformCredentialController extends Controller
{
    protected $automationService;

    public function __construct(PlatformAutomationService $automationService)
    {
        $this->automationService = $automationService;
    }

    /**
     * Display credentials management page
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $credentials = PlatformCredential::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();
        $supportedPlatforms = $this->automationService->getSupportedPlatforms();

        return Inertia::render('Credentials/Index', [
            'credentials' => $credentials,
            'supportedPlatforms' => $supportedPlatforms,
        ]);
    }

    /**
     * Store new platform credentials
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required|string|in:linkedin,naukri,gulftalent,indeed',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'platform_user_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $platform = $request->platform;

        try {
            // Check if credentials already exist for this platform
            $existingCredential = PlatformCredential::where('user_id', $user->id)
                ->where('platform', $platform)
                ->where('is_active', true)
                ->first();

            $credentialData = [
                'user_id' => $user->id,
                'platform' => $platform,
                'platform_user_id' => $request->platform_user_id,
                'credentials' => [
                    'email' => $request->email,
                    'password' => $request->password,
                ],
                'is_active' => true,
                'settings' => [
                    'auto_sync' => true,
                    'sync_frequency' => 'on_update',
                ],
            ];

            if ($existingCredential) {
                // Update existing credentials
                $existingCredential->update($credentialData);
                $message = ucfirst($platform) . ' credentials updated successfully';
            } else {
                // Create new credentials
                PlatformCredential::create($credentialData);
                $message = ucfirst($platform) . ' credentials added successfully';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'platform' => $platform
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save credentials: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update existing credentials
     */
    public function update(Request $request, PlatformCredential $credential)
    {
        // Check if user owns this credential
        if ($credential->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'platform_user_id' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = [
                'platform_user_id' => $request->platform_user_id,
                'credentials' => [
                    'email' => $request->email,
                    'password' => $request->password,
                ],
                'is_active' => $request->boolean('is_active', true),
            ];

            $credential->update($updateData);

            return response()->json([
                'success' => true,
                'message' => ucfirst($credential->platform) . ' credentials updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update credentials: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete platform credentials
     */
    public function destroy(Request $request, PlatformCredential $credential)
    {
        // Check if user owns this credential
        if ($credential->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $credential->delete();

            return response()->json([
                'success' => true,
                'message' => ucfirst($credential->platform) . ' credentials removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove credentials: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle credentials active status
     */
    public function toggle(Request $request, PlatformCredential $credential)
    {
        // Check if user owns this credential
        if ($credential->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $credential->update([
                'is_active' => !$credential->is_active
            ]);

            $status = $credential->is_active ? 'deactivated' : 'activated';

            return response()->json([
                'success' => true,
                'message' => ucfirst($credential->platform) . ' credentials ' . $status . ' successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update credentials: ' . $e->getMessage()
            ], 500);
        }
    }
}
