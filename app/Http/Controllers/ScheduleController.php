<?php

namespace App\Http\Controllers;

use App\Models\Feeder;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $days = [
            1 => __('days.monday'),
            2 => __('days.tuesday'),
            3 => __('days.wednesday'),
            4 => __('days.thursday'),
            5 => __('days.friday'),
            6 => __('days.saturday'),
            7 => __('days.sunday'),
        ];
    
        try {
            $query = Feeder::where('id_user', Auth::id());
    
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
    
            $feeders = $query->with('schedules')->get();
    
            foreach ($feeders as $feeder) {
                if ($feeder->last_fed_at) {
                    $lastFedAt = \Carbon\Carbon::parse($feeder->last_fed_at);
    
                    if ($lastFedAt->diffInMinutes(now()) >= 15) {
                        $feeder->status = 0;
                        $feeder->save();
                    }
                }
            }
    
            return view('schedule.index', compact('feeders', 'days'));
    
        } catch (Throwable $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Schedules',
                'message' => 'Failed to load schedules.',
            ]);
        }
    }

    public function search(Request $request)
    {

    }

    public function store(Request $request, $feeder_id)
    {
        $request->merge([
            'time' => substr($request->time, 0, 5)
        ]);

        $validated = $request->validate([
            'time' => 'required|date_format:H:i',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:always,specific',
            'days' => 'nullable|array',
            'days.*' => 'in:1,2,3,4,5,6,7',
        ]);

        if ($validated['type'] == 'always') {
            $validated['days'] = null;
        }

        try {
            $feeder = Feeder::where('id', $feeder_id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            if ($validated['type'] === 'always') {
                $validated['days'] = null;
            }

            $validated['feeder_id'] = $feeder_id;

            Schedule::create($validated);

            return redirect()->back()->with('toast', [
                'type' => 'success',
                'title' => 'Schedules',
                'message' => 'Schedule created successfully.',
            ]);

        } catch (Throwable $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Schedules',
                'message' => 'Failed to create schedule.',
            ]);
        }
    }

    public function update(Request $request, $schedule_id)
    {
        $validated = $request->validate([
            'feeder_id' => 'required|exists:feeders,id',
            'time' => 'required|date_format:H:i',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:always,specific',
            'days' => 'nullable|array',
            'days.*' => 'in:1,2,3,4,5,6,7',
        ]);

        if ($validated['type'] == 'always') {
            $validated['days'] = null;
        }

        try {
            $feeder = Feeder::where('id', $validated['feeder_id'])
                ->where('id_user', Auth::id())
                ->firstOrFail();

            $schedule = Schedule::where('id', $schedule_id)
                ->where('feeder_id', $feeder->id)
                ->firstOrFail();

            $schedule->update($validated);

            return redirect()->back()->with('toast', [
                'type' => 'success',
                'title' => 'Schedules',
                'message' => 'Schedule updated successfully.',
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Schedules',
                'message' => 'Failed to update schedule.',
            ]);
        }
    }

    public function destroy(Schedule $schedule)
    {
        try {
            abort_if($schedule->feeder->id_user !== Auth::id(), 403);
    
            Schedule::destroy($schedule->id);
    
            return redirect()->back()->with('toast', [
                'type' => 'success',
                'title' => 'Schedules',
                'message' => 'Schedule deleted successfully.',
            ]);
    
        } catch (Throwable $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Schedules',
                'message' => 'Failed to delete schedule.',
            ]);
        }
    }
}