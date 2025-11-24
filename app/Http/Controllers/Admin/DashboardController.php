<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Schedule;
use App\Models\Truck;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistics
        $totalUsers = User::count();
        $totalReports = Report::count();
        $activeSchedules = Schedule::where('status', 'active')->count();
        $activeTrucks = Truck::where('status', 'active')->count();

        // Reports by status for chart
        $pendingReports = Report::where('status', 'pending')->count();
        $resolvedReports = Report::where('status', 'resolved')->count();
        $rejectedReports = Report::where('status', 'rejected')->count();

        // Reports overview chart data (by status)
        $reportsChartData = [
            'labels' => ['Pending', 'Resolved', 'Rejected'],
            'data' => [$pendingReports, $resolvedReports, $rejectedReports],
            'colors' => ['#eab308', '#16a34a', '#dc2626'],
        ];

        // User roles chart data
        $totalAdmins = User::where('is_admin', true)->count();
        $totalRegularUsers = User::where('is_admin', false)->count();
        
        $usersChartData = [
            'labels' => ['Regular Users', 'Admins'],
            'data' => [$totalRegularUsers, $totalAdmins],
            'colors' => ['#16a34a', '#2563eb'],
        ];

        // Recent reports (last 5)
        $recentReports = Report::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'activePage' => 'dashboard',
            'totalUsers' => $totalUsers,
            'totalReports' => $totalReports,
            'activeSchedules' => $activeSchedules,
            'activeTrucks' => $activeTrucks,
            'reportsChartData' => $reportsChartData,
            'usersChartData' => $usersChartData,
            'recentReports' => $recentReports,
        ]);
    }
}
