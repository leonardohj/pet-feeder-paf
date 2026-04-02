<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FeederController extends Controller
{
    public function index()
    {
        $feeders = Feeder::where('id_user', Auth::id())->get();
    return view('feeder.index', compact('feeders'));
    }
    
    public function store(Request $request)
    {
        $lastFeeder = Feeder::latest('id')->value('id');

        $data = [
            'name' => 'Feeder ' . ($lastFeeder ? $lastFeeder + 1 : 1),
            'code' =>  hexdec(uniqid()),
            'status' => false,
            'device_token' =>  Str::random(60)

        ];
        
        Feeder::create($data);

        return redirect()->back();
    }

    public function linkingFeederUser(Request $request)
    {

        $id_user = Auth::user()->id;
        $validation = $request->validate([
            'code' => 'required|exists:feeders,code',
        ]);

        $code = $request->input('code');

        $feeder = Feeder::where('code', $code)->first();

        if($feeder)
        {
            $feeder->id_user = $id_user;
            $feeder->save();
        }

        return redirect()->back();
    }

    public function show(Request $request, $feeder_id)
    {
        try {
            // Eager load feedingLogs
            $feeder = Feeder::with(['feedingLogs' => function ($query) {
                $query->orderBy('date', 'desc'); // latest first
            }])
            ->where('id', $feeder_id)
            ->where('id_user', Auth::id()) // ensures user owns this feeder
            ->firstOrFail();

            return view('feeder.show', compact('feeder'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('feeder.index')->with('error', 'Feeder not found or not yours.');
        }            
    }
}
