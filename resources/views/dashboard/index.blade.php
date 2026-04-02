@extends('layouts.app')

@section('body')
<div class="px-5 py-2 w-full">
  <div class="flex w-full flex-wrap justify-center gap-3">
    <div class="flex flex-col gap-8 mb-10 w-full items-center">

      <!-- Alimentações Feitas Chart Section -->
      <div class="relative w-full max-w-4xl mx-auto mt-10 px-4 flex items-center justify-center">
        <button id="prevFeeder" class="absolute left-0 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-full shadow transition">
          ‹
        </button>

        <div class="w-full px-10">
          <canvas id="feedingChart" class="w-full h-80"></canvas>
        </div>

        <button id="nextFeeder" class="absolute right-0  bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-full shadow transition">
          ›
        </button>
      </div>

      <!-- Estatísticas -->
      <div class="w-full max-w-5xl bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Estatísticas Semanais/Mensais</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
          <div class="bg-gray-100 rounded-lg p-4">
            <p class="text-sm text-gray-500">Total Ração Libertada</p>
            <p id="totalFeed" class="text-2xl font-bold text-gray-900">0g</p>
          </div>
          <div class="bg-gray-100 rounded-lg p-4">
            <p class="text-sm text-gray-500">Média Diária</p>
            <p id="avgFeed" class="text-2xl font-bold text-gray-900">0g</p>
          </div>
          <div class="bg-gray-100 rounded-lg p-4">
            <p class="text-sm text-gray-500">Número de Alimentações</p>
            <p id="feedCount" class="text-2xl font-bold text-gray-900">0</p>
          </div>
          <div class="bg-gray-100 rounded-lg p-4">
            <p class="text-sm text-gray-500">Última Alimentação</p>
            <p id="lastFeed" class="text-2xl font-bold text-gray-900">–</p>
          </div>
        </div>
      </div>

      <!-- Histórico -->
      <div class="w-full max-w-5xl bg-white rounded-xl shadow-md p-6 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-gray-800">Histórico de Alimentações</h2>
          <div class="flex gap-2">
            <button id="exportBtn" class="px-3 py-1.5 text-sm rounded-full bg-blue-600 hover:bg-blue-700 text-white transition">
              Exportar CSV
            </button>
            <button id="clearBtn" class="px-3 py-1.5 text-sm rounded-full bg-red-600 hover:bg-red-700 text-white transition">
              Limpar
            </button>
          </div>
        </div>

        <table class="min-w-full text-sm text-gray-700">
          <thead class="bg-gray-100 rounded-t-full">
            <tr>
              <th class="py-2 px-4 border-b border-gray-600 rounded-tl-xl text-left">Data</th>
              <th class="py-2 px-4 border-b border-gray-600 text-left">Hora</th>
              <th class="py-2 px-4 border-b border-gray-600 text-left">Quantidade (g)</th>
              <th class="py-2 px-4 border-b border-gray-600 rounded-tr-xl text-left">Alimentador</th>
            </tr>
          </thead>
          <tbody id="feedTableBody"></tbody>
        </table>
      </div>

    </div>
  </div>
</div>
@php
$feedersJson = $feeders->map(function($feeder) {
    return [
        'name' => $feeder->name,
        'logs' => $feeder->feedingLogs->map(function($log) {
            return [
                'date' => $log->date->format('Y-m-d'),
                'time' => $log->date->format('H:i'),
                'amount' => $log->quantity,
                'feeder' => $log->feeder->name ?? '' // optional safety
            ];
        })->toArray(),
    ];
})->toArray();
@endphp
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const feeders = @json($feedersJson);

  let currentFeeder = 0;
  const ctx = document.getElementById('feedingChart').getContext('2d');
  const tableBody = document.getElementById('feedTableBody');

  const chartConfig = {
    type: 'bar',
    data: {
      labels: [], datasets: [{
        label: '',
        data: [],
        backgroundColor: 'rgba(75, 85, 99, 0.8)',
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { beginAtZero: true, title: { display: true, text: 'Quantidade (g)' } },
        x: { title: { display: true, text: 'Dia da Semana' } }
      },
      plugins: { legend: { display: false }, title: { display: true, text: '' } }
    }
  };

  const feedingChart = new Chart(ctx, chartConfig);

  function updateChart() {
    const feeder = feeders[currentFeeder];
    const logs = feeder.logs;

    // Aggregate data by day of week
    const days = ['Seg','Ter','Qua','Qui','Sex','Sáb','Dom'];
    const dataByDay = days.map(day => {
      return logs
        .filter(log => new Date(log.date).getDay() === (days.indexOf(day)+1)%7)
        .reduce((sum, log) => sum + log.amount, 0);
    });

    feedingChart.data.labels = days;
    feedingChart.data.datasets[0].data = dataByDay;
    feedingChart.data.datasets[0].label = feeder.name;
    feedingChart.options.plugins.title.text = `${feeder.name} - Alimentações Feitas`;
    feedingChart.update();

    // Update table
    tableBody.innerHTML = logs.map(log => `
      <tr>
        <td class="py-2 px-4 border-b border-gray-300">${log.date}</td>
        <td class="py-2 px-4 border-b border-gray-300">${log.time}</td>
        <td class="py-2 px-4 border-b border-gray-300">${log.amount}g</td>
        <td class="py-2 px-4 border-b border-gray-300">${log.feeder}</td>
      </tr>
    `).join('');

    // Update stats
    const total = logs.reduce((sum, log) => sum + log.amount, 0);
    const avg = logs.length ? total / logs.length : 0;
    const last = logs[logs.length-1];
    document.getElementById('totalFeed').innerText = total + 'g';
    document.getElementById('avgFeed').innerText = avg.toFixed(1) + 'g';
    document.getElementById('feedCount').innerText = logs.length;
    document.getElementById('lastFeed').innerText = last ? `${last.date} ${last.time}` : '–';
  }

  document.getElementById('prevFeeder').addEventListener('click', () => {
    currentFeeder = (currentFeeder - 1 + feeders.length) % feeders.length;
    updateChart();
  });

  document.getElementById('nextFeeder').addEventListener('click', () => {
    currentFeeder = (currentFeeder + 1) % feeders.length;
    updateChart();
  });

  document.getElementById('exportBtn').addEventListener('click', () => {
    const logs = feeders[currentFeeder].logs;
    const csv = [
      ['Data','Hora','Quantidade','Alimentador'],
      ...logs.map(log => [log.date, log.time, log.amount, log.feeder])
    ].map(e => e.join(",")).join("\n");

    const blob = new Blob([csv], { type: 'text/csv' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'historico_alimentacoes.csv';
    a.click();
  });

  document.getElementById('clearBtn').addEventListener('click', () => {
    if(confirm("Deseja realmente limpar o histórico?")) {
      tableBody.innerHTML = "";
      feedingChart.data.datasets[0].data = [];
      feedingChart.update();
      document.getElementById('totalFeed').innerText = "0g";
      document.getElementById('avgFeed').innerText = "0g";
      document.getElementById('feedCount').innerText = "0";
      document.getElementById('lastFeed').innerText = "–";
    }
  });

  updateChart();
</script>
@endsection