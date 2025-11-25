<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Get user's reports with likes and comments counts
        $userReports = Report::where('user_id', $user->id)
            ->withCount(['likes', 'comments'])
            ->with(['likes', 'comments' => function ($query) {
                $query->latest()->take(3)->with('user');
            }])
            ->orderByDesc('created_at')
            ->get();

        return view('profile', [
            'activePage' => 'profile',
            'user' => $user,
            'userReports' => $userReports,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                ],
            ]);
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Update a user's own report.
     */
    public function updateReport(Request $request, Report $report): JsonResponse
    {
        // Ensure the report belongs to the authenticated user
        if ($report->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'description' => ['required', 'string', 'max:1000'],
            'location' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'], // 5MB max
        ]);

        $report->description = $validated['description'];
        $report->location = $validated['location'];

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Additional MIME type validation
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid image type. Only JPEG, PNG, GIF, and WebP are allowed.',
                ], 422);
            }

            // Delete old image if exists
            if ($report->image_path && Storage::disk('public')->exists($report->image_path)) {
                Storage::disk('public')->delete($report->image_path);
            }

            // Generate unique filename
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('reports', $filename, 'public');
            $report->image_path = $imagePath;
        }

        $report->save();

        return response()->json([
            'success' => true,
            'message' => 'Report updated successfully',
            'report' => $report->load(['user', 'likes', 'comments'])->loadCount(['likes', 'comments']),
        ]);
    }

    /**
     * Delete a user's own report.
     */
    public function deleteReport(Report $report): JsonResponse
    {
        // Ensure the report belongs to the authenticated user
        if ($report->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Delete associated image if exists
        if ($report->image_path && Storage::disk('public')->exists($report->image_path)) {
            Storage::disk('public')->delete($report->image_path);
        }

        // Delete associated likes and comments
        $report->likes()->delete();
        $report->comments()->delete();
        $report->followers()->detach();

        // Delete the report
        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Report deleted successfully',
        ]);
    }
}

