@extends('layouts.admin')

@section('page_title', 'Project Detail')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.projects.index') }}" class="admin-text-muted" style="text-decoration: none; font-size: 0.875rem;">← Back to Projects</a>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
            <h1 class="admin-page-header-title" style="margin: 0;">{{ $project->title }}</h1>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn-sm">Edit</a>
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Status Badges --}}
    <div style="display: flex; gap: 0.75rem; margin-bottom: 2rem;">
        <span class="admin-badge {{ $project->is_published ? 'admin-badge-success' : 'admin-badge-warning' }}">
            {{ $project->is_published ? 'Published' : 'Draft' }}
        </span>
        @if($project->featured)
            <span class="admin-badge admin-badge-info">Featured</span>
        @endif
        @if($project->category)
            <span class="admin-badge admin-badge-neutral">{{ $project->category }}</span>
        @endif
    </div>

    {{-- Main Image --}}
    @if($project->image)
        <div class="admin-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" style="width: 100%; max-height: 500px; object-fit: cover;">
        </div>
    @endif

    {{-- Basic Info --}}
    <div class="admin-card" style="margin-bottom: 1.5rem;">
        <h3 class="admin-card-header">Basic Information</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div>
                <div class="admin-label">Title</div>
                <div style="font-weight: 600;">{{ $project->title }}</div>
            </div>
            <div>
                <div class="admin-label">Slug</div>
                <div class="admin-text-muted" style="font-size: 0.875rem;">{{ $project->slug }}</div>
            </div>
            <div>
                <div class="admin-label">Category</div>
                <div>{{ $project->category ?? '—' }}</div>
            </div>
            <div>
                <div class="admin-label">Sort Order</div>
                <div>{{ $project->sort_order }}</div>
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($project->description)
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 class="admin-card-header">Description</h3>
            <div style="color: rgba(255,255,255,0.7); line-height: 1.7; white-space: pre-wrap;">{{ $project->description }}</div>
        </div>
    @endif

    {{-- Short Description --}}
    @if($project->short_description)
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 class="admin-card-header">Short Description</h3>
            <div style="color: rgba(255,255,255,0.6);">{{ $project->short_description }}</div>
        </div>
    @endif

    {{-- Project Details --}}
    <div class="admin-card" style="margin-bottom: 1.5rem;">
        <h3 class="admin-card-header">Project Details</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            @if($project->client)
                <div>
                    <div class="admin-label">Client</div>
                    <div>{{ $project->client }}</div>
                </div>
            @endif
            @if($project->duration)
                <div>
                    <div class="admin-label">Duration</div>
                    <div>{{ $project->duration }}</div>
                </div>
            @endif
            @if($project->completed_at)
                <div>
                    <div class="admin-label">Completed</div>
                    <div>{{ $project->completed_at->format('F Y') }}</div>
                </div>
            @endif
            @if($project->live_url)
                <div>
                    <div class="admin-label">Live URL</div>
                    <a href="{{ $project->live_url }}" target="_blank" class="admin-text-info" style="text-decoration: none;">{{ $project->live_url }}</a>
                </div>
            @endif
            @if($project->github_url)
                <div>
                    <div class="admin-label">GitHub</div>
                    <a href="{{ $project->github_url }}" target="_blank" class="admin-text-info" style="text-decoration: none;">{{ $project->github_url }}</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Technologies --}}
    @if(!empty($project->technologies))
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 class="admin-card-header">Technologies</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                @foreach($project->technologies as $tech)
                    <span class="admin-badge admin-badge-neutral">{{ $tech }}</span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Case Study --}}
    @if($project->challenges || $project->solutions || $project->results)
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 class="admin-card-header">Case Study</h3>
            @if($project->challenges)
                <div style="margin-bottom: 1.5rem;">
                    <div class="admin-label">Challenges</div>
                    <div style="color: rgba(255,255,255,0.7); line-height: 1.7; white-space: pre-wrap;">{{ $project->challenges }}</div>
                </div>
            @endif
            @if($project->solutions)
                <div style="margin-bottom: 1.5rem;">
                    <div class="admin-label">Solutions</div>
                    <div style="color: rgba(255,255,255,0.7); line-height: 1.7; white-space: pre-wrap;">{{ $project->solutions }}</div>
                </div>
            @endif
            @if($project->results)
                <div>
                    <div class="admin-label">Results</div>
                    <div style="color: rgba(255,255,255,0.7); line-height: 1.7; white-space: pre-wrap;">{{ $project->results }}</div>
                </div>
            @endif
        </div>
    @endif

    {{-- Testimonial --}}
    @if($project->testimonial)
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 class="admin-card-header">Testimonial</h3>
            <blockquote style="color: rgba(255,255,255,0.7); line-height: 1.7; font-style: italic; margin-bottom: 1rem;">
                "{{ $project->testimonial }}"
            </blockquote>
            @if($project->testimonial_author)
                <div style="color: rgba(255,255,255,0.5); font-size: 0.875rem;">
                    — {{ $project->testimonial_author }}
                    @if($project->testimonial_position)
                        , {{ $project->testimonial_position }}
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{-- SEO --}}
    @if($project->seo_title || $project->seo_description || $project->seo_keywords)
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 class="admin-card-header">SEO</h3>
            <div style="display: grid; gap: 1rem;">
                @if($project->seo_title)
                    <div>
                        <div class="admin-label">SEO Title</div>
                        <div>{{ $project->seo_title }}</div>
                    </div>
                @endif
                @if($project->seo_description)
                    <div>
                        <div class="admin-label">SEO Description</div>
                        <div class="admin-text-muted">{{ $project->seo_description }}</div>
                    </div>
                @endif
                @if($project->seo_keywords)
                    <div>
                        <div class="admin-label">SEO Keywords</div>
                        <div class="admin-text-muted">{{ $project->seo_keywords }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Meta Info --}}
    <div class="admin-card">
        <h3 class="admin-card-header">Meta Information</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.875rem;">
            <div>
                <div class="admin-label">Created At</div>
                <div>{{ $project->created_at->format('d M Y, H:i') }}</div>
            </div>
            <div>
                <div class="admin-label">Updated At</div>
                <div>{{ $project->updated_at->format('d M Y, H:i') }}</div>
            </div>
            <div>
                <div class="admin-label">Project ID</div>
                <div class="admin-text-muted">#{{ $project->id }}</div>
            </div>
            <div>
                <div class="admin-label">View on Site</div>
                <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="admin-text-info" style="text-decoration: none;">Open ↗</a>
            </div>
        </div>
    </div>
</div>
@endsection