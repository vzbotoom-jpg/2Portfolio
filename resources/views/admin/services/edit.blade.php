@extends('layouts.admin')

@section('page_title', 'Edit Service')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.services.index') }}" style="color: rgba(255,255,255,0.5); text-decoration: none; font-size: 0.875rem;">
            ← Back to Services
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; letter-spacing: 0.05em; margin: 0.5rem 0 0;">
            Edit Service: {{ $service->title }}
        </h1>
    </div>

    <form action="{{ route('admin.services.update', $service) }}" 
          method="POST" 
          enctype="multipart/form-data"
          style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        @method('PUT')

        {{-- Basic Info --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Basic Information
            </h3>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="admin-label">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $service->title) }}" required class="admin-input">
                    @error('title')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" class="admin-input">
                    @error('slug')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label class="admin-label">Short Description</label>
                <input type="text" name="short_description" value="{{ old('short_description', $service->short_description) }}" class="admin-input" maxlength="500">
                @error('short_description')
                    <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label class="admin-label">Full Description *</label>
                <textarea name="description" rows="6" required class="admin-textarea">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="admin-label">Icon</label>
                    <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" class="admin-input">
                    @error('icon')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" class="admin-input" min="0">
                    @error('sort_order')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Image --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Image
            </h3>
            @if($service->image)
                <div style="margin-bottom: 1rem;">
                    <label class="admin-label">Current Image</label>
                    <img src="{{ asset('storage/' . $service->image) }}" 
                         alt="{{ $service->title }}" 
                         style="max-width: 300px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.1);">
                </div>
            @endif
            <div>
                <label class="admin-label">New Image (optional)</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="admin-input">
                <p style="color: rgba(255,255,255,0.3); font-size: 0.75rem; margin-top: 0.25rem;">Leave empty to keep current image</p>
                @error('image')
                    <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Pricing --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Pricing
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="admin-label">Starting Price</label>
                    <input type="number" name="pricing_start" value="{{ old('pricing_start', $service->pricing_start) }}" step="0.01" min="0" class="admin-input">
                    @error('pricing_start')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="admin-label">Pricing Unit</label>
                    <input type="text" name="pricing_unit" value="{{ old('pricing_unit', $service->pricing_unit) }}" class="admin-input">
                    @error('pricing_unit')
                        <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Features --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Features
            </h3>
            <div id="features-container">
                @php 
                    $oldFeatures = old('features', $service->features ?? []);
                    $featureIndex = 0;
                @endphp
                @forelse($oldFeatures as $feature)
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;" class="feature-item">
                        <input type="text" name="features[]" value="{{ $feature }}" class="admin-input" placeholder="Feature description">
                        <button type="button" onclick="this.parentElement.remove()" class="admin-btn admin-btn-danger" style="padding: 0.5rem 1rem;">×</button>
                    </div>
                    @php $featureIndex++; @endphp
                @empty
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;" class="feature-item">
                        <input type="text" name="features[]" class="admin-input" placeholder="Feature description">
                        <button type="button" onclick="this.parentElement.remove()" class="admin-btn admin-btn-danger" style="padding: 0.5rem 1rem;">×</button>
                    </div>
                @endforelse
            </div>
            <button type="button" onclick="addFeature()" class="admin-btn" style="margin-top: 0.5rem;">+ Add Feature</button>
        </div>

        {{-- Process Steps --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Process Steps
            </h3>
            <div id="process-container">
                @php 
                    $oldSteps = old('process_steps', $service->process_steps ?? []);
                    $processIndex = 0;
                @endphp
                @forelse($oldSteps as $step)
                    <div style="border: 1px solid rgba(255,255,255,0.1); padding: 1rem; margin-bottom: 1rem; border-radius: 4px;" class="process-item">
                        <div style="display: grid; grid-template-columns: 1fr 2fr auto; gap: 1rem; align-items: start;">
                            <div>
                                <label class="admin-label">Title</label>
                                <input type="text" name="process_steps[{{ $processIndex }}][title]" value="{{ $step['title'] ?? '' }}" class="admin-input">
                            </div>
                            <div>
                                <label class="admin-label">Description</label>
                                <textarea name="process_steps[{{ $processIndex }}][description]" rows="2" class="admin-textarea">{{ $step['description'] ?? '' }}</textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="admin-btn admin-btn-danger" style="padding: 0.5rem 1rem; margin-top: 1.5rem;">×</button>
                        </div>
                    </div>
                    @php $processIndex++; @endphp
                @empty
                    <div style="border: 1px solid rgba(255,255,255,0.1); padding: 1rem; margin-bottom: 1rem; border-radius: 4px;" class="process-item">
                        <div style="display: grid; grid-template-columns: 1fr 2fr auto; gap: 1rem; align-items: start;">
                            <div>
                                <label class="admin-label">Title</label>
                                <input type="text" name="process_steps[0][title]" class="admin-input">
                            </div>
                            <div>
                                <label class="admin-label">Description</label>
                                <textarea name="process_steps[0][description]" rows="2" class="admin-textarea"></textarea>
                            </div>
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="admin-btn admin-btn-danger" style="padding: 0.5rem 1rem; margin-top: 1.5rem;">×</button>
                        </div>
                    </div>
                @endforelse
            </div>
            <button type="button" onclick="addProcessStep()" class="admin-btn" style="margin-top: 0.5rem;">+ Add Process Step</button>
        </div>

        {{-- Status --}}
        <div class="admin-card">
            <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                Status
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="admin-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                        <label>Active</label>
                    </label>
                </div>
                <div>
                    <label class="admin-checkbox">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}>
                        <label>Featured</label>
                    </label>
                </div>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.services.index') }}" class="admin-btn">
                Cancel
            </a>
            <button type="submit" class="admin-btn admin-btn-primary">
                Update Service
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
let featureIndex = {{ $featureIndex }};
let processIndex = {{ $processIndex }};

function addFeature() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.className = 'feature-item';
    div.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
    div.innerHTML = `
        <input type="text" name="features[]" class="admin-input" placeholder="Feature description">
        <button type="button" onclick="this.parentElement.remove()" class="admin-btn admin-btn-danger" style="padding: 0.5rem 1rem;">×</button>
    `;
    container.appendChild(div);
}

function addProcessStep() {
    const container = document.getElementById('process-container');
    const div = document.createElement('div');
    div.className = 'process-item';
    div.style.cssText = 'border: 1px solid rgba(255,255,255,0.1); padding: 1rem; margin-bottom: 1rem; border-radius: 4px;';
    div.innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr 2fr auto; gap: 1rem; align-items: start;">
            <div>
                <label class="admin-label">Title</label>
                <input type="text" name="process_steps[${processIndex}][title]" class="admin-input">
            </div>
            <div>
                <label class="admin-label">Description</label>
                <textarea name="process_steps[${processIndex}][description]" rows="2" class="admin-textarea"></textarea>
            </div>
            <button type="button" onclick="this.parentElement.parentElement.remove()" class="admin-btn admin-btn-danger" style="padding: 0.5rem 1rem; margin-top: 1.5rem;">×</button>
        </div>
    `;
    container.appendChild(div);
    processIndex++;
}
</script>
@endpush
@endsection