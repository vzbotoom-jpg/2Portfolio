@extends('layouts.admin')

@section('page_title', 'Manage Skills')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 700; letter-spacing: 0.05em; margin: 0;">
            Skills
        </h2>
        <p style="color: rgba(255,255,255,0.4); font-size: 0.875rem; margin: 0.25rem 0 0;">
            Kelola keahlian teknis Anda
        </p>
    </div>
    <a href="{{ route('admin.skills.create') }}" class="admin-btn admin-btn-primary">
        + Add Skill
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
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Expert Level
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">
            {{ $stats['expert'] }}
        </div>
    </div>
</div>

{{-- Filter/Search --}}
<div class="admin-card" style="margin-bottom: 1.5rem;">
    <form action="{{ route('admin.skills.index') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label class="admin-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Search skills...">
        </div>
        <div>
            <label class="admin-label">Category</label>
            <select name="category" class="admin-input" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
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
            <label class="admin-label">Level</label>
            <select name="level" class="admin-input" onchange="this.form.submit()">
                <option value="">All Levels</option>
                <option value="expert" {{ request('level') === 'expert' ? 'selected' : '' }}>Expert (90%+)</option>
                <option value="advanced" {{ request('level') === 'advanced' ? 'selected' : '' }}>Advanced (70-89%)</option>
                <option value="intermediate" {{ request('level') === 'intermediate' ? 'selected' : '' }}>Intermediate (50-69%)</option>
            </select>
        </div>
        <button type="submit" class="admin-btn">Filter</button>
    </form>
</div>

{{-- Skills Table --}}
<div class="admin-card" style="padding: 0; overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Level</th>
                <th>Status</th>
                <th>Featured</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($skills as $skill)
            <tr>
                <td>
                    <div>
                        <div style="font-weight: 600;">{{ $skill->name }}</div>
                        @if($skill->description)
                            <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; margin-top: 0.25rem;">
                                {{ Str::limit($skill->description, 50) }}
                            </div>
                        @endif
                    </div>
                </td>
                <td style="color: rgba(255,255,255,0.5); font-size: 0.875rem;">
                    {{ $skill->category ?? '—' }}
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="flex: 1; height: 4px; background: rgba(255,255,255,0.1); border-radius: 2px; overflow: hidden;">
                            <div style="width: {{ $skill->level }}%; height: 100%; background: {{ $skill->level >= 90 ? '#10b981' : ($skill->level >= 70 ? '#3b82f6' : '#f59e0b') }};"></div>
                        </div>
                        <span style="font-size: 0.75rem; color: rgba(255,255,255,0.5); min-width: 3rem;">
                            {{ $skill->level }}%
                        </span>
                    </div>
                </td>
                <td>
                    <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; {{ $skill->is_active ? 'background: rgba(16,185,129,0.1); color: #10b981;' : 'background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.4);' }}">
                        {{ $skill->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    @if($skill->is_featured)
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; background: rgba(59,130,246,0.1); color: #3b82f6;">
                            Featured
                        </span>
                    @else
                        <span style="color: rgba(255,255,255,0.3); font-size: 0.75rem;">—</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.skills.edit', $skill) }}" class="admin-btn" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                            Edit
                        </a>
                        <form action="{{ route('admin.skills.destroy', $skill) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this skill?')">
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
                    No skills found. Create your first skill!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($skills->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $skills->links() }}
</div>
@endif
@endsection