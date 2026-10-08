@extends('layouts.admin')

@section('page_title', 'Manage Services')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 700; letter-spacing: 0.05em; margin: 0;">
            Services
        </h2>
        <p style="color: rgba(255,255,255,0.4); font-size: 0.875rem; margin: 0.25rem 0 0;">
            Kelola layanan yang Anda tawarkan
        </p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="admin-btn admin-btn-primary">
        + Add Service
    </a>
</div>

{{-- Stats --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Total
        </div>
        <div style="font-size: 1.5rem; font-weight: 700;">
            {{ $stats['total'] }}
        </div>
    </div>
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Active
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #10b981;">
            {{ $stats['active'] }}
        </div>
    </div>
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Featured
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #3b82f6;">
            {{ $stats['featured'] }}
        </div>
    </div>
</div>

{{-- Filter/Search --}}
<div class="admin-card" style="margin-bottom: 1.5rem;">
    <form action="{{ route('admin.services.index') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label class="admin-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Search services...">
        </div>
        <div>
            <label class="admin-label">Status</label>
            <select name="status" class="admin-input" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div>
            <label class="admin-label">Featured</label>
            <select name="featured" class="admin-input" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured</option>
                <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Not Featured</option>
            </select>
        </div>
        <button type="submit" class="admin-btn">Filter</button>
    </form>
</div>

{{-- Services Table --}}
<div class="admin-card" style="padding: 0; overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Icon</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Order</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->title }}" 
                                 style="width: 48px; height: 48px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.05); border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 24px; height: 24px; color: rgba(255,255,255,0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <div style="font-weight: 600;">{{ $service->title }}</div>
                            @if($service->short_description)
                                <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; margin-top: 0.25rem;">
                                    {{ Str::limit($service->short_description, 50) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="color: rgba(255,255,255,0.5); font-size: 0.875rem;">
                    {{ $service->icon ?? '—' }}
                </td>
                <td>
                    <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; {{ $service->is_active ? 'background: rgba(16,185,129,0.1); color: #10b981;' : 'background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.4);' }}">
                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    @if($service->is_featured)
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; background: rgba(59,130,246,0.1); color: #3b82f6;">
                            Featured
                        </span>
                    @else
                        <span style="color: rgba(255,255,255,0.3); font-size: 0.75rem;">—</span>
                    @endif
                </td>
                <td style="color: rgba(255,255,255,0.5); font-size: 0.875rem;">
                    {{ $service->sort_order }}
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.services.edit', $service) }}" class="admin-btn" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                            Edit
                        </a>
                        <form action="{{ route('admin.services.destroy', $service) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this service?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 3rem; color: rgba(255,255,255,0.3);">
                    No services found. Create your first service!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($services->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $services->links() }}
</div>
@endif
@endsection