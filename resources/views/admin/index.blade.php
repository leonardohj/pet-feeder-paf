@extends('layouts.app')

@section('body')

<div class="px-5 w-full flex flex-col">
  
  <div class="ml-auto w-full max-w-3xs px-3 sm:px-5">
    <form action="{{ route('feeder.create') }}" method="POST">
      @csrf

      <x-button type="submit">
        + Criar feeder
      </x-button>

    </form>
  </div>
<x-card :max_width="false">
  <div class="flex flex-col gap-3">
    <div class="overflow-x-auto">
        <table class="min-w-full h-full divide-y divide-gray-300">

            <thead>
                <tr>
                    <th scope="col"
                        class="py-3.5 pl-0 pr-3 text-left text-sm font-semibold text-gray-900">
                        ID
                    </th>

                    <th scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Name
                    </th>

                    <th scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Code
                    </th>

                    <th scope="col" class="relative py-3.5 pl-3 pr-4 text-right w-12">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($feeders as $feeder)
                    <x-clickable-table-row href="#">

                        <td class="whitespace-nowrap py-4 pl-0 pr-3 text-sm font-medium text-gray-900">
                            {{ $feeder->id }}
                        </td>

                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $feeder->name }}
                        </td>

                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 font-mono">
                            {{ $feeder->code }}
                        </td>

                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm"
                            onclick="event.stopPropagation()">

                            <div class="inline-flex items-center gap-4">
                                {{-- actions (opcional) --}}
                                <a href="{{route('feeder.show', ['feeder_id' => $feeder->id])}}"
                                   class="text-gray-400 hover:text-gray-800">
                                    view
                                </a>

                                <a href="{{route('feeder.edit', ['feeder_id' => $feeder->id])}}"
"
                                   class="text-gray-400 hover:text-gray-800">
                                    edit
                                </a>
                            </div>

                        </td>

                    </x-clickable-table-row>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="flex justify-center items-center text-sm py-6 text-gray-500">
                                Não existem feeders
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

  <div class="mt-4">
    {{ $feeders->links() }}
  </div>

</div>
</x-card>

@endsection