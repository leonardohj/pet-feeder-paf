@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumbs class="mb-4" :links="[
        __('breadcrumbs.settings') => route('schedule'),
    ]" />
@endsection

@section('body')
    <x-card title="{{ __('settings.language') }}">
        <x-select label="{{ __('settings.language') }}" onchange="changeLanguage(this.value)" :options="['en' => 'English', 'pt' => 'Português']" :selected="App::getLocale()">
        </x-select>
    </x-card>
@endsection
