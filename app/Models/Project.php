<?php

// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'category',
        'short_description',
        'description',
        'image',
        'thumbnail',
        'gallery',
        'technologies',
        'live_url',
        'github_url',
        'client',
        'duration',
        'completed_at',
        'challenges',
        'solutions',
        'results',
        'testimonial',
        'testimonial_author',
        'testimonial_position',
        'sort_order',
        'is_published',
        'featured',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'meta_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'technologies' => 'array',
        'gallery' => 'array',
        'meta_data' => 'array',
        'completed_at' => 'date',
        'is_published' => 'boolean',
        'featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string>
     */
    protected $dates = [
        'completed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_published' => false,
        'featured' => false,
        'sort_order' => 0,
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug when creating
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = static::generateUniqueSlug($project->title);
            }
            
            if (empty($project->sort_order)) {
                $project->sort_order = static::max('sort_order') + 1;
            }
        });

        // Update slug when title changes
        static::updating(function ($project) {
            if ($project->isDirty('title') && empty($project->slug)) {
                $project->slug = static::generateUniqueSlug($project->title, $project->id);
            }
        });

        // Clean up files when deleting
        static::deleting(function ($project) {
            if ($project->isForceDeleting()) {
                // Delete image files
                if ($project->image) {
                    \Storage::disk('public')->delete($project->image);
                }
                if ($project->thumbnail) {
                    \Storage::disk('public')->delete($project->thumbnail);
                }
                if ($project->gallery) {
                    foreach ($project->gallery as $image) {
                        \Storage::disk('public')->delete($image);
                    }
                }
            }
        });
    }

    /**
     * Generate a unique slug.
     */
    public static function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        $query = static::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Scopes
     */
    
    /**
     * Scope for published projects.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for featured projects.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope for projects by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for projects by technology.
     */
    public function scopeByTechnology($query, $technology)
    {
        return $query->whereJsonContains('technologies', $technology);
    }

    /**
     * Scope for ordered projects.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Scope for recent projects.
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()->ordered()->take($limit);
    }

    /**
     * Scope for related projects.
     */
    public function scopeRelated($query, $project)
    {
        return $query->where('id', '!=', $project->id)
            ->published()
            ->where(function ($q) use ($project) {
                $q->where('category', $project->category)
                    ->orWhere(function ($subQuery) use ($project) {
                        if (!empty($project->technologies)) {
                            foreach ($project->technologies as $tech) {
                                $subQuery->orWhereJsonContains('technologies', $tech);
                            }
                        }
                    });
            })
            ->ordered()
            ->take(3);
    }

    /**
     * Relationships
     */

    /**
     * Get the skills associated with the project.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skill')
            ->withPivot('relevance_level')
            ->withTimestamps();
    }

    /**
     * Accessors & Mutators
     */

    /**
     * Get the project's image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        
        return asset('images/projects/placeholder.webp');
    }

    /**
     * Get the project's thumbnail URL.
     */
    public function getThumbnailUrlAttribute()
    {
        if (! $this->thumbnail) {
            return $this->image_url;
        }

        $storagePath = public_path('storage/' . ltrim($this->thumbnail, '/'));
        $publicPath = public_path(ltrim($this->thumbnail, '/'));

        if (file_exists($storagePath)) {
            return asset('storage/' . ltrim($this->thumbnail, '/'));
        }

        if (file_exists($publicPath)) {
            return asset(ltrim($this->thumbnail, '/'));
        }

        return $this->image_url;
    }

    /**
     * Get the project's gallery URLs.
     */
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) {
            return [];
        }

        return collect($this->gallery)->map(function ($image) {
            return asset('storage/' . $image);
        })->toArray();
    }

    /**
     * Get the project's technology list as string.
     */
    public function getTechnologyListAttribute()
    {
        if (!$this->technologies) {
            return '';
        }

        return implode(', ', $this->technologies);
    }

    /**
     * Get the project's duration in a readable format.
     */
    public function getFormattedDurationAttribute()
    {
        if ($this->completed_at && $this->duration) {
            return $this->duration . ' • Completed ' . $this->completed_at->format('M Y');
        }
        
        return $this->duration;
    }

    /**
     * Get the project's status badge.
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->is_published) {
            return '<span class="bg-green-500/10 text-green-400 px-3 py-1 rounded-full text-xs">Published</span>';
        }
        
        return '<span class="bg-yellow-500/10 text-yellow-400 px-3 py-1 rounded-full text-xs">Draft</span>';
    }

    /**
     * Get the project's featured badge.
     */
    public function getFeaturedBadgeAttribute()
    {
        if ($this->featured) {
            return '<span class="bg-blue-500/10 text-blue-400 px-3 py-1 rounded-full text-xs">Featured</span>';
        }
        
        return '';
    }

    /**
     * Get the next project.
     */
    public function getNextAttribute()
    {
        return static::where('sort_order', '>', $this->sort_order)
            ->published()
            ->orderBy('sort_order', 'asc')
            ->first();
    }

    /**
     * Get the previous project.
     */
    public function getPreviousAttribute()
    {
        return static::where('sort_order', '<', $this->sort_order)
            ->published()
            ->orderBy('sort_order', 'desc')
            ->first();
    }

    /**
     * Get route key name for model binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Convert the model to an array for API responses.
     */
    public function toApiArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'image' => $this->image_url,
            'thumbnail' => $this->thumbnail_url,
            'gallery' => $this->gallery_urls,
            'technologies' => $this->technologies,
            'live_url' => $this->live_url,
            'github_url' => $this->github_url,
            'client' => $this->client,
            'duration' => $this->formatted_duration,
            'completed_at' => $this->completed_at?->format('Y-m-d'),
            'challenges' => $this->challenges,
            'solutions' => $this->solutions,
            'results' => $this->results,
            'featured' => $this->featured,
            'next' => $this->next ? [
                'title' => $this->next->title,
                'slug' => $this->next->slug,
            ] : null,
            'previous' => $this->previous ? [
                'title' => $this->previous->title,
                'slug' => $this->previous->slug,
            ] : null,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}