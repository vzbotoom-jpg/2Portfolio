<?php

// app/Models/Skill.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'category',
        'level',
        'description',
        'icon',
        'color',
        'sort_order',
        'is_active',
        'is_featured',
        'years_of_experience',
        'certification_url',
        'meta_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'level' => 'integer',
        'years_of_experience' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'meta_data' => 'array',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
        'is_featured' => false,
        'level' => 0,
        'sort_order' => 0,
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($skill) {
            if (empty($skill->slug)) {
                $skill->slug = \Illuminate\Support\Str::slug($skill->name);
            }
            if (empty($skill->sort_order)) {
                $skill->sort_order = static::max('sort_order') + 1;
            }
        });
    }

    /**
     * Scopes
     */
    
    /**
     * Scope for active skills.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured skills.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for skills by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for ordered skills.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('level', 'desc');
    }

    /**
     * Scope for skills above a certain level.
     */
    public function scopeExpertLevel($query, $minLevel = 80)
    {
        return $query->where('level', '>=', $minLevel);
    }

    /**
     * Relationships
     */

    /**
     * Get the projects associated with the skill.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skill')
            ->withPivot('relevance_level')
            ->withTimestamps();
    }

    /**
     * Accessors & Mutators
     */

    /**
     * Get the skill level as a percentage bar width.
     */
    public function getLevelPercentageAttribute()
    {
        return min(100, max(0, $this->level));
    }

    /**
     * Get the skill level category.
     */
    public function getLevelCategoryAttribute()
    {
        if ($this->level >= 90) {
            return 'Expert';
        } elseif ($this->level >= 70) {
            return 'Advanced';
        } elseif ($this->level >= 50) {
            return 'Intermediate';
        } elseif ($this->level >= 30) {
            return 'Basic';
        }
        return 'Beginner';
    }

    /**
     * Get the skill level badge color.
     */
    public function getLevelColorAttribute()
    {
        return match(true) {
            $this->level >= 90 => 'emerald',
            $this->level >= 70 => 'blue',
            $this->level >= 50 => 'yellow',
            $this->level >= 30 => 'orange',
            default => 'gray',
        };
    }

    /**
     * Set the name attribute and auto-generate slug.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
        }
    }

    /**
     * Get the skill icon HTML.
     */
    public function getIconHtmlAttribute()
    {
        if (!$this->icon) {
            return '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>';
        }

        return '<i class="' . $this->icon . '"></i>';
    }

    /**
     * Get the years of experience badge.
     */
    public function getExperienceBadgeAttribute()
    {
        if (!$this->years_of_experience) {
            return '';
        }

        $years = $this->years_of_experience;
        $text = $years == 1 ? '1 year' : $years . ' years';
        
        return '<span class="text-xs text-white/40">' . $text . ' experience</span>';
    }

    /**
     * Convert the model to an array for API responses.
     */
    public function toApiArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category,
            'level' => $this->level,
            'level_percentage' => $this->level_percentage,
            'level_category' => $this->level_category,
            'description' => $this->description,
            'years_of_experience' => $this->years_of_experience,
            'icon' => $this->icon,
            'color' => $this->color,
            'featured' => $this->is_featured,
            'created_at' => $this->created_at?->format('Y-m-d'),
            'updated_at' => $this->updated_at?->format('Y-m-d'),
        ];
    }
}