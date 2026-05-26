<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feeder;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FeederController extends Controller
{
    public function index()
    {

        try {
            $feeders = Feeder::where('id_user', Auth::id())->get();

            foreach ($feeders as $feeder) {
                if ($feeder->last_fed_at) {
                    $lastFedAt = \Carbon\Carbon::parse($feeder->last_fed_at);

                    if ($lastFedAt->diffInMinutes(now()) >= 15) {
                        $feeder->status = 0;
                        $feeder->save();
                    }
                }
            }

            return view('feeder.index', compact('feeders'));

        } catch (\Exception $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Feeders',
                'message' => 'Failed to load feeders.',
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $lastFeeder = Feeder::latest('id')->value('id');

            $data = [
                'name' => 'Feeder ' . ($lastFeeder ? $lastFeeder + 1 : 1),
                'code' => hexdec(uniqid()),
                'status' => false,
                'device_token' => Str::random(60)
            ];

            Feeder::create($data);

            return redirect()->back()->with('toast', [
                'type' => 'success',
                'title' => 'Feeders',
                'message' => 'Feeder was created sucessfully.',
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Feeders',
                'message' => 'Failed to create feeder.',
            ]);
        }
    }

    public function linkingFeederUser(Request $request)
    {
        try {
            $id_user = Auth::user()->id;

            $validation = $request->validate([
                'code' => 'required|exists:feeders,code',
            ]);

            $code = $request->input('code');

            $feeder = Feeder::where('code', $code)->first();

            if ($feeder) {
                $feeder->id_user = $id_user;
                $feeder->save();
            }

            return redirect()->back()->with('toast', [
                'type' => 'success',
                'title' => 'Linked Feeder',
                'message' => 'Feeder was linked sucessfully.',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Linked Feeder',
                'message' => 'Failed to link feeder.',
            ]);
        }
    }

    public function show(Request $request, $feeder_id)
    {
        try {
            $feeder = Feeder::with([
                'feedingLogs' => function ($query) {
                    $query->orderBy('date', 'desc');
                }
            ])
                ->where('id', $feeder_id)
                ->when(auth()->user()->getRole() !== 'admin', function ($query) {
                    $query->where('id_user', Auth::id());
                })
                ->firstOrFail();

            $way = 'show';

            return view('feeder.show', compact('feeder', 'way'));

        } catch (ModelNotFoundException $e) {
            return redirect()->route('feeder.index')->with('toast', [
                'type' => 'error',
                'title' => 'Feeders',
                'message' => 'Feeder not found or not yours.',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Feeders',
                'message' => 'Something went wrong.',
            ]);
        }
    }

    public function edit(Request $request, $feeder_id)
    {
        try {
            $feeder = Feeder::with([
                'feedingLogs' => function ($query) {
                    $query->orderBy('date', 'desc');
                }
            ])
                ->where('id', $feeder_id)
                ->when(auth()->user()->getRole() !== 'admin', function ($query) {
                    $query->where('id_user', Auth::id());
                })
                ->firstOrFail();

            $way = 'edit';

            return view('feeder.show', compact('feeder', 'way'));

        } catch (ModelNotFoundException $e) {
            return redirect()->route('feeder.index')->with('toast', [
                'type' => 'error',
                'title' => 'Feeders',
                'message' => 'Feeder not found or not yours.',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Feeders',
                'message' => 'Something went wrong.',
            ]);
        }
    }

    public function update($feeder_id, Request $request)
    {
        try {
            $feeder = Feeder::findOrFail($feeder_id);

            if (auth()->user()->getRole() !== 'admin') {
                $validated = $request->validate([
                    'name' => 'required|string',
                ]);
            } else {
                $validated = $request->validate([
                    'name' => 'required|string|max:30',
                    'device_token' => 'nullable|string',
                    'code' => 'nullable|string'
                ]);
            }

            $feeder->update($validated);

            return redirect()->route('feeder.show', [
                'feeder_id' => $feeder->id
            ])->with('toast', [
                        'type' => 'success',
                        'title' => 'Feeders',
                        'message' => 'Feeder updated sucessfully.',
                    ]);

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Feeders',
                'message' => 'Feeder not found.',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Feeders',
                'message' => 'Something went wrong.',
            ]);
        }
    }
    public function feedManually(Feeder $feeder, Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:50',
        ]);




        Schedule::create([
            'feeder_id' => $feeder->id,
            'time' => Carbon::now()->format('H:i'),
            'quantity' => $request->input('quantity'),
            'type' => 'manual',
        ]);


        return redirect()->route('feeder.show', [
            'feeder_id' => $feeder->id
        ])->with('toast', [
                    'type' => 'success',
                    'title' => 'Feeders',
                    'message' => 'Feeder feeded manually sucessfully.',
                ]);

    }
}