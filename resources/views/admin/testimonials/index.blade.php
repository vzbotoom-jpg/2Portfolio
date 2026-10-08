@extends('layouts.admin')

@section('page_title', 'Manage Testimonials')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 700; letter-spacing: 0.05em; margin: 0;">
            Testimonials
        </h2>
        <p style="color: rgba(255,255,255,0.4); font-size: 0.875rem; margin: 0.25rem 0 0;">
            Kelola testimoni dari klien Anda
        </p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="admin-btn admin-btn-primary">
        + Add Testimonial
    </a>
</div>

{{-- Stats --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
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
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Verified
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">
            {{ $stats['verified'] }}
        </div>
    </div>
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Avg Rating
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #fbbf24;">
            {{ $stats['average_rating'] }} ★
        </div>
    </div>
</div>

{{-- Filter/Search --}}
<div class="admin-card" style="margin-bottom: 1.5rem;">
    <form action="{{ route('admin.testimonials.index') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label class="admin-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Search testimonials...">
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
        <div>
            <label class="admin-label">Min Rating</label>
            <select name="rating" class="admin-input" onchange="this.form.submit()">
                <option value="">All Ratings</option>
                <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>5 Stars</option>
                <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>4+ Stars</option>
                <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>3+ Stars</option>
            </select>
        </div>
        <button type="submit" class="admin-btn">Filter</button>
    </form>
</div>

{{-- Testimonials Table --}}
<div class="admin-card" style="padding: 0; overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Author</th>
                <th>Content</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Featured</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testimonials as $testimonial)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        @if($testimonial->avatar)
                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" 
                                 alt="{{ $testimonial->name }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-weight: 700; color: rgba(255,255,255,0.4); font-size: 0.875rem;">
                                {{ $testimonial->initials }}
                            </div>
                        @endif
                        <div>
                            <div style="font-weight: 600;">{{ $testimonial->name }}</div>
                            @if($testimonial->position)
                                <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem;">
                                    {{ $testimonial->position }}
                                    @if($testimonial->company)
                                        @ {{ $testimonial->company }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="max-width: 300px;">
                    <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem; line-height: 1.5;">
                        {{ Str::limit($testimonial->content, 100) }}
                    </div>
                </td>
                <td>
                    <div style="display: flex; gap: 2px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color: {{ $i <= $testimonial->rating ? '#fbbf24' : 'rgba(255,255,255,0.1)' }};">
                                ★
                            </span>
                        @endfor
                    </div>
                </td>
                <td>
                    <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; {{ $testimonial->is_active ? 'background: rgba(16,185,129,0.1); color: #10b981;' : 'background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.4);' }}">
                        {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    @if($testimonial->is_featured)
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; background: rgba(59,130,246,0.1); color: #3b82f6;">
                            Featured
                        </span>
                    @else
                        <span style="color: rgba(255,255,255,0.3); font-size: 0.75rem;">—</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="admin-btn" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                            Edit
                        </a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
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
                    No testimonials found. Create your first testimonial!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($testimonials->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $testimonials->links() }}
</div>
@endif
@endsection