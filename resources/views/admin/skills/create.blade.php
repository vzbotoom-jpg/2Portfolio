@extends('layouts.admin')

@section('page_title', 'Create Skill')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.skills.index') }}" style="color: rgba(255,255,255,0.5); text-decoration: none; font-size: 0.875rem;">
            ← Back to Skills
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; letter-spacing: 0.05em; margin: 0.5rem 0 0;">
            Create New Skill
        </h1>
    </div>

    <form action="{{ route('admin.skills.store') }}" 
          method="POST" 
          style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf

        {{-- Basic Info --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Basic Information
            </h3>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="admin-label">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="admin-input" placeholder="e.g., Laravel">
                    @error('name')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="admin-input" placeholder="auto-generated">
                    <p style="color: rgba(255,255,255,0.3); font-size: 0.75rem; margin-top: 0.25rem;">Leave empty to auto-generate</p>
                    @error('slug')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="admin-label">Category *</label>
                    <select name="category" required class="admin-input">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Level (0-100) *</label>
                    <input type="number" name="level" value="{{ old('level', 80) }}" min="0" max="100" required class="admin-input" placeholder="80">
                    @error('level')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label class="admin-label">Description</label>
                <textarea name="description" rows="3" class="admin-textarea" placeholder="Brief description of your experience with this skill">{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="admin-label">Icon</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" class="admin-input" placeholder="e.g., fab fa-laravel">
                    @error('icon')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Color</label>
                    <input type="text" name="color" value="{{ old('color') }}" class="admin-input" placeholder="e.g., #FF2D20">
                    @error('color')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Additional Info --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Additional Information
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="admin-label">Years of Experience</label>
                    <input type="number" name="years_of_experience" value="{{ old('years_of_experience') }}" min="0" class="admin-input" placeholder="5">
                    @error('years_of_experience')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order') }}" min="0" class="admin-input" placeholder="0">
                    @error('sort_order')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label class="admin-label">Certification URL</label>
                <input type="url" name="certification_url" value="{{ old('certification_url') }}" class="admin-input" placeholder="https://...">
                @error('certification_url')
                    <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Status --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Status
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="admin-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label>Active</label>
                    </label>
                </div>
                <div>
                    <label class="admin-checkbox">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label>Featured</label>
                    </label>
                </div>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.skills.index') }}" class="admin-btn">
                Cancel
            </a>
            <button type="submit" class="admin-btn admin-btn-primary">
                Create Skill
            </button>
        </div>
    </form>
</div>
@endsection