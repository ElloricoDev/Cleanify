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

        // Send email notification to the user who submitted the report
        if ($report->user && $report->user->email_notifications) {
            try {
                $report->user->notify(new \App\Notifications\ReportResolvedNotification($report));
            } catch (\Exception $e) {
                \Log::error('Failed to send report resolved notification: ' . $e->getMessage());
            }
        }

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

        // Send email notification to the user who submitted the report
        if ($report->user && $report->user->email_notifications) {
            try {
                $report->user->notify(new \App\Notifications\ReportRejectedNotification($report));
            } catch (\Exception $e) {
                \Log::error('Failed to send report rejected notification: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.reports')
            ->with('success', 'Report rejected successfully!');
    }
}
