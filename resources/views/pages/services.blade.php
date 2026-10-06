{{-- resources/views/pages/services.blade.php --}}
@extends('layouts.app')

@section('title', 'Services')
@section('meta_description', 'Web development, mobile apps, UI/UX design, and consulting services.')

@section('content')

<div class="pt-32 lg:pt-40">
    @include('components.sections.services-section', [
        'title' => 'SERVICES',
        'services' => collect($services)->map(function ($service, $slug) {
            return array_merge($service, ['slug' => $slug]);
        })->values()->all(),
    ])
</div>

@endsection