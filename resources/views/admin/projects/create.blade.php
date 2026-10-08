@extends('layouts.admin')

@section('page_title', 'Create Project')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.projects.index') }}" class="admin-text-muted" style="text-decoration: none; font-size: 0.875rem;">← Back to Projects</a>
        <h1 class="admin-page-header-title" style="margin-top: 0.5rem;">Create New Project</h1>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf

        {{-- Basic Info --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Basic Information</h3>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="admin-input" placeholder="e.g., E-Commerce Platform">
                    @error('title') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="admin-input" placeholder="auto-generated">
                </div>
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Category *</label>
                <select name="category" required class="admin-select">
                    <option value="">Select category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Short Description</label>
                <input type="text" name="short_description" value="{{ old('short_description') }}" class="admin-input" maxlength="500" placeholder="Brief description (max 500 characters)">
                @error('short_description') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Full Description *</label>
                <textarea name="description" rows="6" required class="admin-textarea" placeholder="Detailed project description...">{{ old('description') }}</textarea>
                @error('description') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Images --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Images</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Main Image *</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" required class="admin-input">
                    <p class="admin-text-muted" style="font-size: 0.75rem; margin-top: 0.25rem;">Max 5MB. JPEG, PNG, WebP</p>
                    @error('image') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" class="admin-input">
                    <p class="admin-text-muted" style="font-size: 0.75rem; margin-top: 0.25rem;">Max 2MB. Optional</p>
                    @error('thumbnail') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Project Details --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Project Details</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Client</label>
                    <input type="text" name="client" value="{{ old('client') }}" class="admin-input" placeholder="Client name">
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Duration</label>
                    <input type="text" name="duration" value="{{ old('duration') }}" class="admin-input" placeholder="e.g., 3 months">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Live URL</label>
                    <input type="url" name="live_url" value="{{ old('live_url') }}" class="admin-input" placeholder="https://...">
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">GitHub URL</label>
                    <input type="url" name="github_url" value="{{ old('github_url') }}" class="admin-input" placeholder="https://github.com/...">
                </div>
            </div>
            <div class="admin-form-group" style="margin: 0;">
                <label class="admin-label">Completed At</label>
                <input type="date" name="completed_at" value="{{ old('completed_at') }}" class="admin-input">
            </div>
        </div>

        {{-- Technologies --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Technologies</h3>
            <div id="tech-container">
                @php $oldTech = old('technologies', []); @endphp
                @forelse($oldTech as $tech)
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;" class="tech-item">
                        <input type="text" name="technologies[]" value="{{ $tech }}" class="admin-input" placeholder="Technology name">
                        <button type="button" onclick="this.parentElement.remove()" class="admin-btn admin-btn-danger admin-btn-sm">×</button>
                    </div>
                @empty
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;" class="tech-item">
                        <input type="text" name="technologies[]" class="admin-input" placeholder="Technology name">
                        <button type="button" onclick="this.parentElement.remove()" class="admin-btn admin-btn-danger admin-btn-sm">×</button>
                    </div>
                @endforelse
            </div>
            <button type="button" onclick="addTech()" class="admin-btn admin-btn-sm" style="margin-top: 0.5rem;">+ Add Technology</button>
        </div>

        {{-- Skills Association --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Related Skills</h3>
            <div style="display: grid; gap: 0.75rem;">
                @foreach($skills as $skill)
                    <div style="display: grid; grid-template-columns: 20px 1fr 120px; gap: 0.75rem; align-items: center; padding: 0.75rem 1rem; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; background: rgba(255,255,255,0.02);">
                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}" id="skill_{{ $skill->id }}" {{ in_array($skill->id, old('skills', []), true) ? 'checked' : '' }}>
                        <label for="skill_{{ $skill->id }}" style="color: rgba(255,255,255,0.8); cursor: pointer;">{{ $skill->name }}</label>
                        <input type="number" name="skill_relevance[{{ $skill->id }}]" value="{{ old('skill_relevance.' . $skill->id, 50) }}" min="0" max="100" class="admin-input" placeholder="50%">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Case Study --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Case Study (Optional)</h3>
            <div class="admin-form-group">
                <label class="admin-label">Challenges</label>
                <textarea name="challenges" rows="3" class="admin-textarea" placeholder="What challenges did you face?">{{ old('challenges') }}</textarea>
            </div>
            <div class="admin-form-group">
                <label class="admin-label">Solutions</label>
                <textarea name="solutions" rows="3" class="admin-textarea" placeholder="How did you solve them?">{{ old('solutions') }}</textarea>
            </div>
            <div class="admin-form-group">
                <label class="admin-label">Results</label>
                <textarea name="results" rows="3" class="admin-textarea" placeholder="What were the results?">{{ old('results') }}</textarea>
            </div>
        </div>

        {{-- Testimonial --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Testimonial (Optional)</h3>
            <div class="admin-form-group">
                <label class="admin-label">Testimonial Text</label>
                <textarea name="testimonial" rows="3" class="admin-textarea" placeholder="Client testimonial...">{{ old('testimonial') }}</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Author</label>
                    <input type="text" name="testimonial_author" value="{{ old('testimonial_author') }}" class="admin-input" placeholder="Author name">
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Position</label>
                    <input type="text" name="testimonial_position" value="{{ old('testimonial_position') }}" class="admin-input" placeholder="e.g., CEO, TechCorp">
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="admin-card">
            <h3 class="admin-card-header">SEO (Optional)</h3>
            <div class="admin-form-group">
                <label class="admin-label">SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title') }}" class="admin-input" maxlength="255">
            </div>
            <div class="admin-form-group">
                <label class="admin-label">SEO Description</label>
                <textarea name="seo_description" rows="2" class="admin-textarea" style="min-height: 80px;" maxlength="500">{{ old('seo_description') }}</textarea>
            </div>
            <div class="admin-form-group">
                <label class="admin-label">SEO Keywords</label>
                <input type="text" name="seo_keywords" value="{{ old('seo_keywords') }}" class="admin-input" placeholder="keyword1, keyword2, keyword3">
            </div>
        </div>

        {{-- Status --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Status</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-checkbox">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <label>Published</label>
                    </label>
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-checkbox">
                        <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                        <label>Featured</label>
                    </label>
                </div>
            </div>
            <div class="admin-form-group" style="margin-top: 1rem; margin-bottom: 0;">
                <label class="admin-label">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order') }}" class="admin-input" min="0" placeholder="0">
            </div>
        </div>

        {{-- Submit --}}
        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.projects.index') }}" class="admin-btn">Cancel</a>
            <button type="submit" class="admin-btn admin-btn-primary">Create Project</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function addTech() {
    const container = document.getElementById('tech-container');
    const div = document.createElement('div');
    div.className = 'tech-item';
    div.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
    div.innerHTML = `<input type="text" name="technologies[]" class="admin-input" placeholder="Technology name"><button type="button" onclick="this.parentElement.remove()" class="admin-btn admin-btn-danger admin-btn-sm">×</button>`;
    container.appendChild(div);
}
</script>
@endpush
@endsection