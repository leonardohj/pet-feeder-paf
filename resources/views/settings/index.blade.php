@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumbs class="mb-4" :links="[
        __('breadcrumbs.settings') => route('schedule'),
    ]" />
@endsection

@section('body')
    <x-card title="{{ __('settings.language') }}">
        <x-select 
            label="{{ __('settings.language') }}" 
            name="language"
            onchange="changeLanguage(this.value)" 
            :options="['en' => 'English', 'pt' => 'Português']" 
            :selected="app()->getLocale()"
        />
    </x-card>
@endsection
<script>
    function changeLanguage(lang) {
        window.location = '{{ url('change-language') }}/' + lang;
    }
</script>