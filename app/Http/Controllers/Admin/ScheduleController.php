<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreScheduleRequest;
use App\Http\Requests\Admin\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Truck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Schedule::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('area', 'like', "%{$search}%")
                  ->orWhere('days', 'like', "%{$search}%")
                  ->orWhere('truck', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status && in_array($request->status, ['active', 'pending', 'inactive'])) {
            $query->where('status', $request->status);
        }

        $schedules = $query->orderBy('area', 'asc')->paginate(10);

        // Statistics
        $activeSchedules = Schedule::where('status', 'active')->count();
        $pendingSchedules = Schedule::where('status', 'pending')->count();
        $inactiveSchedules = Schedule::where('status', 'inactive')->count();
        $trucksAssigned = Schedule::where('status', 'active')->distinct('truck')->count('truck');

        // Get zones from config
        $zones = array_keys(config('routes.surigao_city', []));

        // Get trucks from database
        $trucks = Truck::orderBy('code', 'asc')->get();

        return view('admin.schedule', [
            'activePage' => 'schedule',
            'schedules' => $schedules,
            'activeSchedules' => $activeSchedules,
            'pendingSchedules' => $pendingSchedules,
            'inactiveSchedules' => $inactiveSchedules,
            'trucksAssigned' => $trucksAssigned,
            'search' => $request->search ?? '',
            'statusFilter' => $request->status ?? '',
            'zones' => $zones,
            'trucks' => $trucks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request): RedirectResponse
    {
        Schedule::create([
            'area' => $request->area,
            'days' => $request->days,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'truck' => $request->truck,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.schedule')
            ->with('success', 'Schedule created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, string $id): RedirectResponse
    {
        $schedule = Schedule::findOrFail($id);

        $schedule->update([
            'area' => $request->area,
            'days' => $request->days,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'truck' => $request->truck,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.schedule')
            ->with('success', 'Schedule updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedule')
            ->with('success', 'Schedule deleted successfully!');
    }
}
