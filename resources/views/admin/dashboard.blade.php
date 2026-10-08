@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
{{-- Stats Grid --}}
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Projects</div>
        <div class="admin-stat-value">{{ $stats['projects']['total'] }}</div>
        <div class="admin-text-muted" style="font-size: 0.75rem; margin-top: 0.5rem;">
            {{ $stats['projects']['published'] }} published
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Services</div>
        <div class="admin-stat-value">{{ $stats['services']['total'] }}</div>
        <div class="admin-text-muted" style="font-size: 0.75rem; margin-top: 0.5rem;">
            {{ $stats['services']['active'] }} active
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Skills</div>
        <div class="admin-stat-value">{{ $stats['skills']['total'] }}</div>
        <div class="admin-text-muted" style="font-size: 0.75rem; margin-top: 0.5rem;">
            {{ $stats['skills']['active'] }} active
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Unread Messages</div>
        <div class="admin-stat-value admin-stat-value-danger">{{ $stats['messages']['unread'] }}</div>
        <div class="admin-text-muted" style="font-size: 0.75rem; margin-top: 0.5rem;">
            {{ $stats['messages']['total'] }} total
        </div>
    </div>
</div>

{{-- Quick Actions & Recent Messages --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    {{-- Quick Actions --}}
    <div class="admin-card">
        <h3 class="admin-card-header">Quick Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary">+ Add New Project</a>
            <a href="{{ route('admin.services.create') }}" class="admin-btn">+ Add New Service</a>
            <a href="{{ route('admin.skills.create') }}" class="admin-btn">+ Add New Skill</a>
            <a href="{{ route('admin.testimonials.create') }}" class="admin-btn">+ Add New Testimonial</a>
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 class="admin-card-header" style="margin: 0;">Recent Messages</h3>
            <a href="{{ route('admin.messages.index') }}" class="admin-btn admin-btn-sm">View All</a>
        </div>
        @if($recentMessages->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($recentMessages as $message)
                    <a href="{{ route('admin.messages.show', $message) }}" style="text-decoration: none; color: inherit; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $message->name }}</span>
                            @if(!$message->is_read)
                                <span class="admin-badge admin-badge-danger">NEW</span>
                            @endif
                        </div>
                        <div class="admin-text-muted" style="font-size: 0.75rem;">{{ $message->subject }}</div>
                        <div class="admin-text-muted" style="font-size: 0.75rem;">{{ $message->created_at->diffForHumans() }}</div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="admin-empty-state">No messages yet</div>
        @endif
    </div>
</div>
@endsection