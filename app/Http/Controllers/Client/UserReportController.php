<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserReportController extends Controller
{
    /**
     * Store a new user report.
     */
    public function store(Request $request, User $user): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'reason' => ['required', Rule::in(['spam', 'harassment', 'inappropriate_content', 'fake_account', 'other'])],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $reporter = $request->user();
        $reportedUser = $user;

        // Prevent self-reporting
        if ($reporter->id === $reportedUser->id) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You cannot report yourself.'], 422);
            }
            return back()->withErrors(['error' => 'You cannot report yourself.']);
        }

        // Check if user already reported this user
        $existingReport = UserReport::where('reporter_id', $reporter->id)
            ->where('reported_user_id', $reportedUser->id)
            ->first();

        if ($existingReport) {
            // If report is dismissed, allow updating it
            if ($existingReport->status === 'dismissed') {
                $existingReport->update([
                    'reason' => $validated['reason'],
                    'description' => $validated['description'] ?? null,
                    'status' => 'pending',
                    'admin_notes' => null,
                    'reviewed_by' => null,
                    'reviewed_at' => null,
                ]);
                $report = $existingReport;
            } else {
                // Report already exists and is not dismissed
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'You have already reported this user. Please wait for admin review.',
                        'status' => $existingReport->status,
                    ], 422);
                }
                return back()->withErrors(['error' => 'You have already reported this user. Please wait for admin review.']);
            }
        } else {
            // Create a new report
            $report = UserReport::create([
                'reporter_id' => $reporter->id,
                'reported_user_id' => $reportedUser->id,
                'reason' => $validated['reason'],
                'description' => $validated['description'] ?? null,
                'status' => 'pending',
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User reported successfully. Our team will review this report.',
            ]);
        }

        return back()->with('success', 'User reported successfully. Our team will review this report.');
    }
}
