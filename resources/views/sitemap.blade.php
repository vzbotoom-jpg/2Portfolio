<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach([
        ['url' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['url' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['url' => route('projects.index'), 'changefreq' => 'daily', 'priority' => '0.9'],
        ['url' => route('services'), 'changefreq' => 'weekly', 'priority' => '0.8'],
        ['url' => route('contact.index'), 'changefreq' => 'yearly', 'priority' => '0.6'],
    ] as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach
    @foreach($projects as $project)
    <url>
        <loc>{{ route('projects.show', $project->slug) }}</loc>
        <lastmod>{{ isset($project->updated_at) && $project->updated_at ? $project->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
</urlset>
