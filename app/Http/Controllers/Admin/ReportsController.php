<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectReportRequest;
use App\Http\Requests\Admin\ResolveReportRequest;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function index(Request $request): View
    {
        $query = Report::with(['user', 'resolver']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter out reports with deleted users (optional - uncomment if you want to hide orphaned reports)
        // $query->whereHas('user');

        // Filter by status
        if ($request->has('status') && $request->status && in_array($request->status, ['pending', 'resolved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(5);

        // Statistics
        $pendingReports = Report::where('status', 'pending')->count();
        $resolvedReports = Report::where('status', 'resolved')->count();
        $rejectedReports = Report::where('status', 'rejected')->count();
        $thisMonthReports = Report::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.reports', [
            'activePage' => 'reports',
            'reports' => $reports,
            'pendingReports' => $pendingReports,
            'resolvedReports' => $resolvedReports,
            'rejectedReports' => $rejectedReports,
            'thisMonthReports' => $thisMonthReports,
            'search' => $request->search ?? '',
            'statusFilter' => $request->status ?? '',
        ]);
    }

    public function resolve(ResolveReportRequest $request, string $id): RedirectResponse
    {
        $report = Report::findOrFail($id);

        $report->update([
            'status' => 'resolved',
            'admin_notes' => $request->admin_notes,
            'resolved_by' => auth()->id(),
            'resolved_at' => now(),
        ]);

        $this->notifyReportOwner($report, 'resolved');
        $this->notifyFollowers($report, 'resolved');

        return redirect()->route('admin.reports')
            ->with('success', 'Report marked as resolved successfully!');
    }

    public function reject(RejectReportRequest $request, string $id): RedirectResponse
    {
        $report = Report::findOrFail($id);

        $report->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'resolved_by' => auth()->id(),
            'resolved_at' => now(),
        ]);

        $this->notifyReportOwner($report, 'rejected');
        $this->notifyFollowers($report, 'rejected');

        return redirect()->route('admin.reports')
            ->with('success', 'Report rejected successfully!');
    }

    protected function notifyReportOwner(Report $report, string $type): void
    {
        if (!$report->user || !$report->user->email_notifications) {
            return;
        }

        try {
            if ($type === 'resolved') {
                $report->user->notify(new \App\Notifications\ReportResolvedNotification($report));
            } else {
                $report->user->notify(new \App\Notifications\ReportRejectedNotification($report));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to notify report owner: ' . $e->getMessage());
        }
    }

    protected function notifyFollowers(Report $report, string $type): void
    {
        $followers = $report->followers()
            ->where('user_id', '!=', $report->user_id)
            ->where('email_notifications', true)
            ->get();

        foreach ($followers as $follower) {
            try {
                if ($type === 'resolved') {
                    $follower->notify(new \App\Notifications\ReportResolvedNotification($report, true));
                } else {
                    $follower->notify(new \App\Notifications\ReportRejectedNotification($report, true));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to notify follower: ' . $e->getMessage());
            }
        }
    }
}
