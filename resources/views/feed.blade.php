<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title>{{ config('app.name', 'Portfolio') }} Projects</title>
        <link>{{ route('projects.index') }}</link>
        <description>Recently published projects</description>
        <language>{{ str_replace('_', '-', app()->getLocale()) }}</language>
        @foreach($projects as $project)
        <item>
            <title>{{ $project->title }}</title>
            <link>{{ route('projects.show', $project->slug) }}</link>
            <guid>{{ route('projects.show', $project->slug) }}</guid>
            <description>{{ strip_tags($project->short_description ?? $project->description ?? '') }}</description>
            <pubDate>{{ isset($project->updated_at) && $project->updated_at ? $project->updated_at->toRfc2822String() : now()->toRfc2822String() }}</pubDate>
        </item>
        @endforeach
    </channel>
</rss>
