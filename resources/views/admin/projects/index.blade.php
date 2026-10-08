@extends('layouts.admin')

@section('page_title', 'Manage Projects')

@section('content')
<div class="admin-page-header">
    <div>
        <h2 class="admin-page-header-title">Projects</h2>
        <p class="admin-page-header-subtitle">Kelola portfolio projects Anda</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn-primary">+ Add Project</a>
</div>

{{-- Stats --}}
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Total</div>
        <div class="admin-stat-value">{{ $stats['total'] }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Published</div>
        <div class="admin-stat-value admin-stat-value-success">{{ $stats['published'] }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Draft</div>
        <div class="admin-stat-value admin-stat-value-warning">{{ $stats['draft'] }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Featured</div>
        <div class="admin-stat-value admin-stat-value-info">{{ $stats['featured'] }}</div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="admin-filter-bar">
    <form action="{{ route('admin.projects.index') }}" method="GET" class="admin-filter-form">
        <div class="admin-form-group" style="margin: 0;">
            <label class="admin-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Search projects...">
        </div>
        <div class="admin-form-group" style="margin: 0;">
            <label class="admin-label">Category</label>
            <select name="category" class="admin-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="admin-form-group" style="margin: 0;">
            <label class="admin-label">Status</label>
            <select name="status" class="admin-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="admin-form-group" style="margin: 0;">
            <label class="admin-label">Featured</label>
            <select name="featured" class="admin-select" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured</option>
                <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Not Featured</option>
            </select>
        </div>
        <button type="submit" class="admin-btn">Filter</button>
    </form>
</div>

{{-- Table --}}
<div class="admin-card" style="padding: 0; overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Order</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" 
                                 alt="{{ $project->title }}" 
                                 style="width: 56px; height: 56px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div style="width: 56px; height: 56px; background: rgba(255,255,255,0.05); border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: rgba(255,255,255,0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <div style="font-weight: 600;">{{ $project->title }}</div>
                            @if($project->client)
                                <div class="admin-text-muted" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $project->client }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="admin-text-muted">{{ $project->category ?? '—' }}</td>
                <td>
                    <span class="admin-badge {{ $project->is_published ? 'admin-badge-success' : 'admin-badge-warning' }}">
                        {{ $project->is_published ? 'Published' : 'Draft' }}
                    </span>
                </td>
                <td>
                    @if($project->featured)
                        <span class="admin-badge admin-badge-info">Featured</span>
                    @else
                        <span class="admin-text-muted" style="font-size: 0.75rem;">—</span>
                    @endif
                </td>
                <td class="admin-text-muted">{{ $project->sort_order }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.projects.show', $project) }}" class="admin-btn admin-btn-sm">View</a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn-sm">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this project?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="admin-empty-state">No projects found. Create your first project!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($projects->hasPages())
<div style="margin-top: 1.5rem;">{{ $projects->links() }}</div>
@endif
@endsection