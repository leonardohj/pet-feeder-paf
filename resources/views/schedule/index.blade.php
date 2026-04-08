@extends('layouts.app')

@section('breadcrumb')
<x-breadcrumbs class="mb-4" :links="[
    __('breadcrumbs.schedules') => route('schedule'),
]" />
@endsection

@section('body')
    <x-card>
        <form method="GET" action="{{ route('schedule') }}">
            <x-search name="search" label="Pesquisar alimentadores" placeholder="Search something..." :value="request('search')">
                @if (request('search'))
                    <a href="{{ route('schedule') }}">
                        <x-mdi-close class="h-5 w-5 text-gray-500 hover:text-gray-400 cursor-pointer" />
                    </a>
                @else
                    <x-mdi-magnify class="h-5 w-5 text-gray-500 hover:text-gray-400" />
                @endif
            </x-search>
        </form>
    </x-card>

    <div x-data="feedersList(
        {{ $feeders->count() }},
        {{ json_encode(
            request('search')
                ? $feeders->filter(fn($f) => str_contains(strtolower($f->name), strtolower(request('search'))))->pluck('id')->values()
                : [],
        ) }}
    )" x-cloak class="mt-4">
        <x-card title="Lista de Alimentadores">

            @forelse($feeders as $feeder)
                <div class="border border-gray-100 rounded-2xl mb-3 shadow-sm bg-white">

                    <!-- Feeder Header -->
                    <button type="button" @click="toggle({{ $feeder->id }})"
                        class="w-full flex justify-between items-center p-4 sm:p-5 text-left focus:outline-none">
                        <div class="flex flex-col">
                            <span class="font-semibold text-gray-800 text-base sm:text-lg">
                                {{ $feeder->name }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">

                            <div
                                class="h-3 w-3 rounded-full {{ $feeder->status ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}">
                            </div>

                            <span
                                class="text-xs sm:text-sm font-semibold {{ $feeder->status ? 'text-green-600' : 'text-red-600' }}">
                                {{ $feeder->status ? 'Online' : 'Offline' }}
                            </span>

                            <svg :class="expanded === {{ $feeder->id }} ? 'rotate-180' : ''"
                                class="ml-2 h-4 w-4 sm:h-5 sm:w-5 text-gray-500 transition-transform"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>

                        </div>
                    </button>


                    <!-- Feeder schedules -->
                    <div x-show="expanded === {{ $feeder->id }}" 
                        class="border-t border-gray-200 px-4 sm:px-5 py-3 sm:py-4">

                        @if ($feeder->schedules->isEmpty())
                            <p class="text-gray-500 text-sm sm:text-base mb-2">
                                Nenhum horário programado.
                            </p>
                        @else
                            <ul class="space-y-2 sm:space-y-3">

                                @foreach ($feeder->schedules as $schedule)
                                    <li class="flex justify-between items-center">

                                        <div class="text-sm sm:text-base">

                                            <div class="font-medium">
                                                {{ $schedule->time }} —
                                                {{ $schedule->type === 'always' ? 'Todos os dias' : implode(', ', $schedule->days) }}
                                            </div>

                                            <div class="text-gray-500">
                                                Quantidade: {{ $schedule->quantity }}g
                                            </div>

                                        </div>

                                        <button type="button"
                                            class="text-blue-600 hover:text-blue-700 text-sm sm:text-base font-medium"
                                            @click="openModal(
    {{ $schedule->id }},
    {{ $feeder->id }},
    '{{ $schedule->time }}',
    {{ $schedule->quantity }},
    '{{ $schedule->type }}',
    {{ json_encode($schedule->days) }}
)">
                                            Editar
                                        </button>

                                    </li>
                                @endforeach

                            </ul>
                        @endif

                        <div class="mt-3 flex justify-end">

                            <button type="button" @click="openModal(null, {{ $feeder->id }})"
                                class="bg-gray-900 w-full hover:bg-gray-800 text-white font-medium px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-sm sm:text-base">
                                + Adicionar horário
                            </button>

                        </div>

                    </div>
                </div>

            @empty

                <p class="text-gray-500 text-center text-sm sm:text-base">
                    Nenhum alimentador associado à sua conta.
                </p>
            @endforelse

        </x-card>



        <!-- Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">

            <div class="bg-white rounded-2xl shadow-lg max-w-md w-full p-6" @click.away="closeModal()">

                <h2 class="text-xl font-semibold mb-4" x-text="modalTitle"></h2>

                <form
                    :action="editing
                        ?
                        '{{ route('schedule.update', ['schedule' => 'SCHEDULE_ID']) }}'.replace('SCHEDULE_ID',
                            scheduleId) :
                        '{{ route('schedule.store', ['feeder_id' => 'FEEDER_ID']) }}'.replace('FEEDER_ID', feederId)"
                    method="POST">

                    @csrf

                    <template x-if="editing">
                        @method('PUT')
                    </template>

                    <input type="hidden" name="feeder_id" :value="feederId">


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Hora
                        </label>

                        <input type="time" name="time" x-model="time" class="w-full border rounded-lg p-2" required>
                    </div>


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Quantidade (g)
                        </label>

                        <input type="number" name="quantity" x-model="quantity" class="w-full border rounded-lg p-2"
                            required min="1">
                    </div>


                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo
                        </label>

                        <select name="type" x-model="type" class="w-full border rounded-lg p-2">

                            <option value="always">Todos os dias</option>
                            <option value="specific">Dias específicos</option>

                        </select>

                    </div>


                    <div class="mb-4" x-show="type === 'specific'">

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Dias
                        </label>

                        <div class="flex flex-wrap gap-2">

                            @foreach (['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'] as $day)
                                <label class="cursor-pointer">

                                    <input type="checkbox" name="days[]" value="{{ $day }}"
                                        :checked="days.includes('{{ $day }}')"
                                        @click="toggleDay('{{ $day }}')" class="hidden">

                                    <span
                                        :class="days.includes('{{ $day }}') ?
                                            'bg-gray-900 text-white' :
                                            'bg-gray-200 text-gray-700'"
                                        class="px-3 py-1 rounded-lg">
                                        {{ $day }}
                                    </span>

                                </label>
                            @endforeach

                        </div>

                    </div>


                    <div class="flex justify-end gap-2 mt-4">

                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">
                            Cancelar
                        </button>

                        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                            Salvar
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>


    <script>
        function feedersList(count, searchMatches = []) {
        
            let firstOpen = null;
        
            if (searchMatches.length) {
                firstOpen = searchMatches[0];
            }
        
            if (!firstOpen && count === 1) {
                firstOpen = {{ $feeders->first()?->id ?? 'null' }};
            }
        
            return {
        
                expanded: firstOpen,
        
                modalOpen: false,
                modalTitle: 'Adicionar Horário',
        
                feederId: null,
                scheduleId: null,
        
                time: '',
                quantity: '',
                type: 'always',
        
                days: [],
                editing: false,
        
        
                toggle(id) {
                    this.expanded = this.expanded === id ? null : id;
                },
        
        
                openModal(
                    scheduleId = null,
                    feederId = null,
                    time = '',
                    quantity = '',
                    type = 'always',
                    days = []
                ) {
                    this.modalOpen = true;
                    this.scheduleId = scheduleId;
                    this.feederId = feederId;
        
                    this.time = time;
                    this.quantity = quantity;
                    this.type = type;
                    this.days = days || [];
        
                    this.editing = !!scheduleId;
                    this.modalTitle = this.editing
                        ? 'Editar Horário'
                        : 'Adicionar Horário';
                },
        
        
                closeModal() {
                    this.modalOpen = false;
        
                    this.scheduleId = null;
                    this.feederId = null;
        
                    this.time = '';
                    this.quantity = '';
                    this.type = 'always';
        
                    this.days = [];
                    this.editing = false;
                },
        
        
                toggleDay(day) {
                    if (this.days.includes(day)) {
                        this.days = this.days.filter(d => d !== day);
                    } else {
                        this.days.push(day);
                    }
                }
        
            };
        
        }
        </script>

@endsection
