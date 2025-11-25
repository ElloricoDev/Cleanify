<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportFeedController extends Controller
{
    /**
     * Store a newly created report/update from the feed.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        Report::create([
            'user_id' => Auth::id(),
            'location' => $validated['location'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Your update has been shared! Our team will take a look soon.');
    }

    /**
     * Toggle like for a report.
     */
    public function toggleLike(Report $report): JsonResponse
    {
        $user = Auth::user();

        $existingLike = $report->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            $report->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        $likesCount = $report->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount,
        ]);
    }

    /**
     * Store a new comment for the report.
     */
    public function storeComment(Request $request, Report $report): JsonResponse
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:500'],
        ]);

        $comment = $report->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ])->load('user');

        $commentsCount = $report->comments()->count();

        return response()->json([
            'comment' => [
                'id' => $comment->id,
                'author' => $comment->user?->name ?? 'Cleanify User',
                'avatar' => $comment->user?->getAvatarBgClasses(),
                'initial' => $comment->user?->getAvatarInitial(),
                'comment' => $comment->comment,
                'timestamp' => $comment->created_at?->diffForHumans() ?? 'Just now',
            ],
            'comments_count' => $commentsCount,
        ]);
    }
}

