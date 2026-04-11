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
        $query = Feeder::where('id_user', Auth::id());

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $feeders = $query->with('schedules')->get();

        return view('schedule.index', compact('feeders', 'days'));
    }
    public function search(Request $request)
    {

    }
    public function store(Request $request, $feeder_id)
    {
        // Trim time to H:i
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

        if($validated['type'] == 'always')
        {
            $validated['days'] = null;
        }
        
        try {
            // Check that feeder belongs to user
            $feeder = Feeder::where('id', $feeder_id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            // Convert days to null if type is 'always'
            if ($validated['type'] === 'always') {
                $validated['days'] = null;
            }

            // Add feeder_id to validated data
            $validated['feeder_id'] = $feeder_id;

            // Create schedule
            Schedule::create($validated);

        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Erro: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Horário criado com sucesso!');
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

        if($validated['type'] == 'always')
        {
            $validated['days'] = null;
        }
        try {
            // verify feeder belongs to logged user
            $feeder = Feeder::where('id', $validated['feeder_id'])
                ->where('id_user', Auth::id())
                ->firstOrFail();

            $schedule = Schedule::where('id', $schedule_id)
                ->where('feeder_id', $feeder->id)
                ->firstOrFail();

            $schedule->update($validated);

            return redirect()->back()->with('success', 'Horário atualizado com sucesso!');

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}