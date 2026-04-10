@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumbs class="mb-4" :links="[
        __('breadcrumbs.pets') => route('schedule'),
    ]" />
@endsection

@section('body')
 @forelse($pets as $pet)
 
 @empty
 <x-no-feeders :title="__('pets.no_pet_title')" :text="__('pets.no_pet_text')" :button_text="__('pets.add_pet')"></x-no-feeders>
 
 @endforelse

@endsection