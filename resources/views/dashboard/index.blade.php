@extends('layouts.app')

@section('breadcrumb')
<x-breadcrumbs class="mb-4" :links="[
    __('breadcrumbs.dashboard') => '',
]" />
@endsection

@php
    $user = Auth::user();
@endphp

@section('body')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@if($user->hasFeeders())
<div class="px-6" x-cloak>
    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="grid grid-cols-2 md:grid-rows-1 grid-rows-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-3 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    
                    <!-- LEFT -->
                    <div class="flex flex-col">
                        <p class="text-sm font-medium text-gray-500">
                            {{ __('dashboard.total_consumed') }}
                        </p>
            
                        <p id="totalFeed" class="text-2xl font-bold text-gray-900 mt-2">
                            0g
                        </p>
                    </div>
            
                    <!-- RIGHT (IMAGE) -->
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('img/food.png') }}" class="h-15entr w-15 object-contain">
                    </div>
            
                </div>
            </div>
            <div class="bg-white p-3 mb:p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500">{{ __('dashboard.avg_per_dose') }}</p>
                    <div class="p-2 hidden md:block bg-blue-50 rounded-lg"><i class="fas fa-chart-line text-blue-600"></i></div>
                </div>
                <p id="avgFeed" class="text-2xl font-bold text-gray-900 mt-2">0g</p>
            </div>
            <div class="bg-white  p-3 mb:p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500">{{ __('dashboard.feeds') }}</p>
                    <div class="p-2 hidden md:block bg-purple-50 rounded-lg"><i class="fas fa-utensils text-purple-600"></i></div>
                </div>
                <p id="feedCount" class="text-2xl font-bold text-gray-900 mt-2">0</p>
            </div>
            <div class="bg-white  p-3 mb:p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500">{{ __('dashboard.status') }}</p>
                    <div class="p-2 hidden md:block bg-orange-50 rounded-lg"><i class="fas fa-signal text-orange-600"></i></div>
                </div>
                <p class="text-lg font-bold text-gray-900 mt-2">Online</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Volume Semanal -->
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-700 uppercase text-xs tracking-wider">{{ __('dashboard.weekly_volume') }}</h3>
                    <div class="flex items-center gap-4">
                        <button id="prevFeeder" class="text-gray-400 hover:text-indigo-600 transition"><i class="fas fa-chevron-left"></i></button>
                        <span id="currentFeederName" class="font-semibold text-gray-700 text-sm">0 Alimentadores</span>
                        <button id="nextFeeder" class="text-gray-400 hover:text-indigo-600 transition"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="feedingChart"></canvas>
                </div>
        
                @unless($user->hasLogs())
                    <div class="absolute inset-0 bg-gray-100 text-center px-6 opacity-60 flex gap-3 flex-col justify-center items-center rounded-2xl z-10 pointer-events-none">
                        <i class="fas fa-lock text-black text-4xl"></i>
                        <div>
                            {{ __('dashboard.blocked_comment') }}
                        </div>
                    </div>
                @endunless
            </div>
        
            <!-- Uso por Equipamento -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative">
                <h3 class="font-bold text-gray-700 uppercase text-xs tracking-wider mb-6">{{ __('dashboard.equipment_usage') }}</h3>
                <div class="h-80 flex items-center justify-center">
                    <canvas id="pizzaChart"></canvas>
                </div>
        
                @unless($user->hasLogs())
                    <div class="absolute inset-0 bg-gray-100 text-center px-6 opacity-60 flex gap-3 flex-col justify-center items-center rounded-2xl z-10 pointer-events-none">
                        <i class="fas fa-lock text-black text-4xl"></i>
                        <div>
                            {{ __('dashboard.feed_to_unlock') }}
                        </div>
                    </div>
                @endunless
            </div>
        
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-2 flex justify-between items-center bg-gray-700">
                <h3 class="font-bold text-white uppercase text-xs tracking-wider">{{ __('dashboard.recent_history') }}</h3>

                <button id="toggleLogs"
                    class="text-xs text-white py-1 px-3 rounded-lg bg-gray-800 hover:bg-gray-900 transition">
                    {{ __('dashboard.see_all') }}
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-800 text-xs text-nowrap uppercase bg-gray-300">
                            <th class="px-6 py-1.5 font-medium">{{ __('dashboard.date_time') }}</th>
                            <th class="px-6 py-1 font-medium">{{ __('dashboard.equipment') }}</th>
                            <th class="px-6 py-1 font-medium text-right">{{ __('dashboard.dose') }}</th>
                        </tr>
                    </thead>

                    <tbody id="feedTableBody" class="divide-y divide-gray-50 text-gray-600">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@php
$feedersJson = $feeders->map(function($feeder) {
    return [
        'name' => $feeder->name,
        'logs' => $feeder->feedingLogs->map(function($log) use ($feeder) {
            return [
                'date' => $log->date->format('Y-m-d'),
                'hour' => $log->hour,
                'amount' => (float) $log->quantity,
                'feeder' => $feeder->name
            ];
        })->toArray(),
    ];
})->toArray();
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const feeders = @json($feedersJson);
    if(feeders.length === 0) return;

    let currentFeederIndex = 0;
    let showAllLogs = false;

    const ctxBar = document.getElementById('feedingChart').getContext('2d');
    const ctxPizza = document.getElementById('pizzaChart').getContext('2d');

    let feedingChart = new Chart(ctxBar,{
        type:'bar',
        data:{
            labels:['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
            datasets:[{
                label:'Gramas',
                backgroundColor:'#6366f1',
                borderRadius:8,
                data:[0,0,0,0,0,0,0]
            }]
        },
        options:{
            maintainAspectRatio:false,
            plugins:{legend:{display:false}},
            scales:{y:{beginAtZero:true}}
        }
    });

    let pizzaChart = new Chart(ctxPizza,{
        type:'doughnut',
        data:{
            labels:feeders.map(f=>f.name),
            datasets:[{
                data:feeders.map(f=>f.logs.reduce((s,l)=>s+l.amount,0)),
                backgroundColor:['#6366f1','#f59e0b','#10b981','#ef4444','#8b5cf6']
            }]
        },
        options:{cutout:'70%',maintainAspectRatio:false}
    });

    function updateUI(){

        const feeder = feeders[currentFeederIndex];
        document.getElementById('currentFeederName').innerText = feeder.name;

        const dataByDay = new Array(7).fill(0);
        feeder.logs.forEach(log=>{
            const dayIdx = new Date(log.date).getDay();
            dataByDay[dayIdx] += log.amount;
        });

        const feederColor = pizzaChart.data.datasets[0].backgroundColor[currentFeederIndex];
        feedingChart.data.datasets[0].data = dataByDay;
        feedingChart.data.datasets[0].backgroundColor = feederColor;
        feedingChart.update();

        const tableBody = document.getElementById('feedTableBody');
        let logs = [...feeder.logs].reverse();
        if(!showAllLogs) logs = logs.slice(0,3);

        tableBody.innerHTML = logs.map(log => `
            <tr class="hover:bg-gray-50 text-sm transition">
                <td class="px-6 py-2">
                    <span class="font-medium text-gray-900">${log.date}</span>
                    <span class="text-gray-400 ml-2">${log.hour}</span>
                </td>
                <td class="px-6 py-2">
                    <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs rounded-md">${log.feeder}</span>
                </td>
                <td class="px-6 py-2 text-right font-bold text-gray-800">${log.amount}g</td>
            </tr>
        `).join('') || '<tr><td colspan="3" class="px-6 py-2 text-center text-sm text-gray-400">{{ __("dashboard.no_logs_yet") }}</td></tr>';

        const allLogs = feeders.flatMap(f => f.logs);
        const total = allLogs.reduce((s,l) => s+l.amount, 0);
        const count = allLogs.length;

        document.getElementById('totalFeed').innerText = `${total.toLocaleString()}g`;
        document.getElementById('avgFeed').innerText = `${count>0 ? (total/count).toFixed(1) : 0}g`;
        document.getElementById('feedCount').innerText = count;
    }

    document.getElementById('prevFeeder').addEventListener('click',()=>{
        currentFeederIndex = (currentFeederIndex - 1 + feeders.length) % feeders.length;
        updateUI();
    });

    document.getElementById('nextFeeder').addEventListener('click',()=>{
        currentFeederIndex = (currentFeederIndex + 1) % feeders.length;
        updateUI();
    });

    document.getElementById('toggleLogs').addEventListener('click',()=>{
        showAllLogs = !showAllLogs;
        document.getElementById('toggleLogs').innerText = showAllLogs ? 'Ver menos' : 'Ver todos';
        updateUI();
    });

    updateUI();
});
</script>

@else
<x-no-feeders title="Não tens um alimentador associado à tua conta?" text="Associa um alimentador para começares a monitorizar e gerir a alimentação facilmente." click="$dispatch('open-modal-associate-feeder')" button_text="Associar alimentador"></x-no-feeders>

@endif

@endsection