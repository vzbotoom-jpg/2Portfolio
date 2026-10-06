<?php

// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'icon',
        'image',
        'features',
        'benefits',
        'process_steps',
        'pricing_start',
        'pricing_unit',
        'sort_order',
        'is_active',
        'is_featured',
        'meta_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'features' => 'array',
        'benefits' => 'array',
        'process_steps' => 'array',
        'meta_data' => 'array',
        'pricing_start' => 'decimal:2',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
        'is_featured' => false,
        'sort_order' => 0,
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
            if (empty($service->sort_order)) {
                $service->sort_order = static::max('sort_order') + 1;
            }
        });
    }

    /**
     * Scopes
     */
    
    /**
     * Scope for active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured services.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordered services.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * Accessors & Mutators
     */

    /**
     * Get the service's image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        
        return asset('images/services/placeholder.svg');
    }

    /**
     * Get the features as a formatted list.
     */
    public function getFeaturesListAttribute()
    {
        if (!$this->features) {
            return [];
        }

        return collect($this->features)->map(function ($feature) {
            return [
                'title' => $feature['title'] ?? $feature,
                'description' => $feature['description'] ?? null,
                'icon' => $feature['icon'] ?? null,
            ];
        })->toArray();
    }

    /**
     * Get the process steps as a formatted list.
     */
    public function getProcessStepsListAttribute()
    {
        if (!$this->process_steps) {
            return [];
        }

        return collect($this->process_steps)->map(function ($step, $index) {
            return [
                'step' => $index + 1,
                'title' => $step['title'] ?? $step,
                'description' => $step['description'] ?? null,
                'duration' => $step['duration'] ?? null,
            ];
        })->toArray();
    }

    /**
     * Get the pricing display.
     */
    public function getPricingDisplayAttribute()
    {
        if (!$this->pricing_start) {
            return 'Contact for pricing';
        }

        $price = number_format($this->pricing_start, 2);
        $unit = $this->pricing_unit ?? 'project';

        return "Starting at \${$price} / {$unit}";
    }

    /**
     * Get the service icon HTML with optional color.
     */
    public function getIconHtmlAttribute()
    {
        $color = $this->icon_color ?? 'currentColor';
        
        if (!$this->icon) {
            return $this->getDefaultIcon();
        }

        return '<i class="' . $this->icon . '" style="color: ' . $color . '"></i>';
    }

    /**
     * Get default icon based on service title.
     */
    private function getDefaultIcon()
    {
        $icons = [
            'web' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>',
            'mobile' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
            'design' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>',
        ];

        // Determine icon based on title keywords
        $title = strtolower($this->title);
        
        foreach ($icons as $key => $icon) {
            if (str_contains($title, $key)) {
                return $icon;
            }
        }

        return $icons['web']; // Default icon
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
            'description' => $this->description,
            'short_description' => $this->short_description,
            'icon' => $this->icon,
            'image' => $this->image_url,
            'features' => $this->features_list,
            'benefits' => $this->benefits,
            'process_steps' => $this->process_steps_list,
            'pricing' => [
                'start' => $this->pricing_start,
                'unit' => $this->pricing_unit,
                'display' => $this->pricing_display,
            ],
            'featured' => $this->is_featured,
            'created_at' => $this->created_at?->format('Y-m-d'),
            'updated_at' => $this->updated_at?->format('Y-m-d'),
        ];
    }
}