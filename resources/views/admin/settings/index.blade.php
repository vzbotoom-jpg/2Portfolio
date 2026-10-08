@extends('layouts.admin')

@section('page_title', 'Settings')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 class="admin-page-header-title">Portfolio Settings</h1>
        <p class="admin-page-header-subtitle">Manage your portfolio configuration and personal information.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        @method('PUT')

        {{-- Personal Information --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Personal Information</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Author Name *</label>
                    <input type="text" name="author" value="{{ old('author', $portfolioConfig['author'] ?? '') }}" required class="admin-input">
                    @error('author') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $portfolioConfig['title'] ?? '') }}" required class="admin-input">
                    @error('title') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $portfolioConfig['email'] ?? '') }}" required class="admin-input">
                    @error('email') <p class="admin-text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $portfolioConfig['phone'] ?? '') }}" class="admin-input">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Location</label>
                    <input type="text" name="location" value="{{ old('location', $portfolioConfig['location'] ?? '') }}" class="admin-input">
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Availability</label>
                    <input type="text" name="availability" value="{{ old('availability', $portfolioConfig['availability'] ?? '') }}" class="admin-input" placeholder="e.g., Available for freelance">
                </div>
            </div>
        </div>

        {{-- Hero Section --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Hero Section</h3>
            
            <div class="admin-form-group">
                <label class="admin-label">Hero Title</label>
                <input type="text" name="hero_title" value="{{ old('hero_title', $portfolioConfig['hero']['title'] ?? '') }}" class="admin-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Hero Subtitle</label>
                <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $portfolioConfig['hero']['subtitle'] ?? '') }}" class="admin-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Hero Description</label>
                <textarea name="hero_description" rows="3" class="admin-textarea">{{ old('hero_description', $portfolioConfig['hero']['description'] ?? '') }}</textarea>
            </div>
        </div>

        {{-- Social Media Links --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Social Media Links</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">GitHub</label>
                    <input type="url" name="social_github" value="{{ old('social_github', $portfolioConfig['social']['github'] ?? '') }}" class="admin-input" placeholder="https://github.com/username">
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">LinkedIn</label>
                    <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $portfolioConfig['social']['linkedin'] ?? '') }}" class="admin-input" placeholder="https://linkedin.com/in/username">
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Twitter</label>
                    <input type="url" name="social_twitter" value="{{ old('social_twitter', $portfolioConfig['social']['twitter'] ?? '') }}" class="admin-input" placeholder="https://twitter.com/username">
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Instagram</label>
                    <input type="url" name="social_instagram" value="{{ old('social_instagram', $portfolioConfig['social']['instagram'] ?? '') }}" class="admin-input" placeholder="https://instagram.com/username">
                </div>
            </div>
        </div>

        {{-- SEO Settings --}}
        <div class="admin-card">
            <h3 class="admin-card-header">SEO Settings</h3>
            
            <div class="admin-form-group">
                <label class="admin-label">Default Meta Description</label>
                <textarea name="seo_description" rows="3" class="admin-textarea">{{ old('seo_description', $seoConfig['defaults']['description'] ?? '') }}</textarea>
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Default Keywords</label>
                <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $seoConfig['defaults']['keywords'] ?? '') }}" class="admin-input" placeholder="keyword1, keyword2, keyword3">
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Twitter Handle</label>
                <input type="text" name="seo_twitter_handle" value="{{ old('seo_twitter_handle', $seoConfig['twitter']['site'] ?? '') }}" class="admin-input" placeholder="@username">
            </div>
        </div>

        {{-- Contact Form Settings --}}
        <div class="admin-card">
            <h3 class="admin-card-header">Contact Form Settings</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Notification Email</label>
                    <input type="email" name="contact_notification_email" value="{{ old('contact_notification_email', $portfolioConfig['contact']['notification_email'] ?? '') }}" class="admin-input">
                </div>
                <div class="admin-form-group" style="margin: 0;">
                    <label class="admin-label">Response Time</label>
                    <input type="text" name="contact_response_time" value="{{ old('contact_response_time', $portfolioConfig['contact']['response_time'] ?? '') }}" class="admin-input" placeholder="e.g., Within 24 hours">
                </div>
            </div>

            <div class="admin-form-group" style="margin-top: 1rem; margin-bottom: 0;">
                <label class="admin-checkbox">
                    <input type="checkbox" name="contact_store_messages" value="1" {{ old('contact_store_messages', $portfolioConfig['contact']['store_messages'] ?? true) ? 'checked' : '' }}>
                    <label>Store messages in database</label>
                </label>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-top: 1rem;">
            <button type="reset" class="admin-btn">Reset Changes</button>
            <button type="submit" class="admin-btn admin-btn-primary">Save Settings</button>
        </div>
    </form>
</div>
@endsection