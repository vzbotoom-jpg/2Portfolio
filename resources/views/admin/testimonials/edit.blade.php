@extends('layouts.admin')

@section('page_title', 'Edit Testimonial')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.testimonials.index') }}" style="color: rgba(255,255,255,0.5); text-decoration: none; font-size: 0.875rem;">
            ← Back to Testimonials
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; letter-spacing: 0.05em; margin: 0.5rem 0 0;">
            Edit Testimonial: {{ $testimonial->name }}
        </h1>
    </div>

    <form action="{{ route('admin.testimonials.update', $testimonial) }}" 
          method="POST" 
          enctype="multipart/form-data"
          style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        @method('PUT')

        {{-- Author Info --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Author Information
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="admin-label">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="admin-input">
                    @error('name')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $testimonial->email) }}" class="admin-input">
                    @error('email')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="admin-label">Position</label>
                    <input type="text" name="position" value="{{ old('position', $testimonial->position) }}" class="admin-input">
                    @error('position')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Company</label>
                    <input type="text" name="company" value="{{ old('company', $testimonial->company) }}" class="admin-input">
                    @error('company')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if($testimonial->avatar)
                <div style="margin-bottom: 1rem;">
                    <label class="admin-label">Current Avatar</label>
                    <img src="{{ asset('storage/' . $testimonial->avatar) }}" 
                         alt="{{ $testimonial->name }}" 
                         style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
                </div>
            @endif

            <div>
                <label class="admin-label">New Avatar (optional)</label>
                <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" class="admin-input">
                <p style="color: rgba(255,255,255,0.3); font-size: 0.75rem; margin-top: 0.25rem;">Leave empty to keep current avatar</p>
                @error('avatar')
                    <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Testimonial Content --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Testimonial Content
            </h3>
            
            <div style="margin-bottom: 1rem;">
                <label class="admin-label">Content *</label>
                <textarea name="content" rows="6" required class="admin-textarea">{{ old('content', $testimonial->content) }}</textarea>
                @error('content')
                    <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="admin-label">Rating * (1-5)</label>
                    <input type="number" name="rating" value="{{ old('rating', $testimonial->rating) }}" min="1" max="5" required class="admin-input">
                    @error('rating')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Testimonial Date</label>
                    <input type="date" name="testimonial_date" value="{{ old('testimonial_date', $testimonial->testimonial_date?->format('Y-m-d')) }}" class="admin-input">
                    @error('testimonial_date')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Project Info --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Project Information (Optional)
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="admin-label">Project Name</label>
                    <input type="text" name="project_name" value="{{ old('project_name', $testimonial->project_name) }}" class="admin-input">
                    @error('project_name')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Project URL</label>
                    <input type="url" name="project_url" value="{{ old('project_url', $testimonial->project_url) }}" class="admin-input">
                    @error('project_url')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Status
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="admin-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                        <label>Active</label>
                    </label>
                </div>
                <div>
                    <label class="admin-checkbox">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}>
                        <label>Featured</label>
                    </label>
                </div>
                <div>
                    <label class="admin-checkbox">
                        <input type="checkbox" name="verified" value="1" {{ old('verified', $testimonial->verified) ? 'checked' : '' }}>
                        <label>Verified</label>
                    </label>
                </div>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.testimonials.index') }}" class="admin-btn">
                Cancel
            </a>
            <button type="submit" class="admin-btn admin-btn-primary">
                Update Testimonial
            </button>
        </div>
    </form>
</div>
@endsection