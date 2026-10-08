{{-- resources/views/pages/services.blade.php --}}
@extends('layouts.app')
@section('title', 'Services')
@section('meta_description', 'Web development, mobile apps, UI/UX design, and consulting services.')
@section('content')
<div class="pt-32 lg:pt-40">
    {{-- Pass services collection directly to the section --}}
    @include('components.sections.services-section', [
        'title' => 'SERVICES',
        'subtitle' => 'Comprehensive digital solutions tailored to your specific needs.',
        'services' => $services ?? [],
    ])
</div>
@endsection