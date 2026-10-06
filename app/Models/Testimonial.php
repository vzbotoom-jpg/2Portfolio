<?php

// app/Models/Testimonial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testimonials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'position',
        'company',
        'email',
        'avatar',
        'content',
        'rating',
        'project_name',
        'project_url',
        'social_links',
        'sort_order',
        'is_active',
        'is_featured',
        'verified',
        'testimonial_date',
        'response',
        'response_date',
        'meta_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'verified' => 'boolean',
        'testimonial_date' => 'date',
        'response_date' => 'date',
        'social_links' => 'array',
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
        'verified' => false,
        'rating' => 5,
        'sort_order' => 0,
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($testimonial) {
            if (empty($testimonial->sort_order)) {
                $testimonial->sort_order = static::max('sort_order') + 1;
            }
            if (empty($testimonial->testimonial_date)) {
                $testimonial->testimonial_date = now();
            }
        });
    }

    /**
     * Scopes
     */
    
    /**
     * Scope for active testimonials.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured testimonials.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for verified testimonials.
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    /**
     * Scope for high-rated testimonials.
     */
    public function scopeHighRated($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Scope for ordered testimonials.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')
            ->orderBy('testimonial_date', 'desc');
    }

    /**
     * Scope for recent testimonials.
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->active()
            ->ordered()
            ->take($limit);
    }

    /**
     * Accessors & Mutators
     */

    /**
     * Get the avatar URL or generate initials avatar.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return $this->getInitialsAvatar();
    }

    /**
     * Generate initials avatar URL.
     */
    private function getInitialsAvatar()
    {
        $name = urlencode($this->name);
        $initials = $this->initials;
        $bgColor = $this->avatar_bg_color ?? '000000';
        $textColor = 'ffffff';

        return "https://ui-avatars.com/api/?name={$name}&background={$bgColor}&color={$textColor}&size=200&bold=true&format=svg";
    }

    /**
     * Get the initials from name.
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }

        return substr($initials, 0, 2);
    }

    /**
     * Get the rating stars HTML.
     */
    public function getRatingStarsAttribute()
    {
        $stars = '';
        $rating = min(5, max(1, $this->rating));

        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<svg class="w-5 h-5 text-yellow-400 inline-block" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
            } else {
                $stars .= '<svg class="w-5 h-5 text-gray-600 inline-block" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
            }
        }

        return $stars;
    }

    /**
     * Get the truncated content.
     */
    public function getExcerptAttribute($length = 150)
    {
        return Str::limit($this->content, $length);
    }

    /**
     * Get the verified badge HTML.
     */
    public function getVerifiedBadgeAttribute()
    {
        if (!$this->verified) {
            return '';
        }

        return '<span class="inline-flex items-center text-blue-400 text-xs ml-2" title="Verified Review">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Verified
        </span>';
    }

    /**
     * Get the formatted testimonial date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->testimonial_date?->format('F Y');
    }

    /**
     * Check if testimonial has a response.
     */
    public function getHasResponseAttribute()
    {
        return !empty($this->response);
    }

    /**
     * Get the social links as formatted array.
     */
    public function getFormattedSocialLinksAttribute()
    {
        if (!$this->social_links) {
            return [];
        }

        return collect($this->social_links)->map(function ($link, $platform) {
            return [
                'platform' => ucfirst($platform),
                'url' => $link,
                'icon' => $this->getSocialIcon($platform),
            ];
        })->values()->toArray();
    }

    /**
     * Get social media icon.
     */
    private function getSocialIcon($platform)
    {
        $icons = [
            'linkedin' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z',
            'twitter' => 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z',
            'github' => 'M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22',
        ];

        return $icons[$platform] ?? '';
    }

    /**
     * Convert the model to an array for API responses.
     */
    public function toApiArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'company' => $this->company,
            'avatar' => $this->avatar_url,
            'initials' => $this->initials,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'rating' => $this->rating,
            'rating_stars' => $this->rating_stars,
            'project_name' => $this->project_name,
            'project_url' => $this->project_url,
            'verified' => $this->verified,
            'testimonial_date' => $this->formatted_date,
            'response' => $this->response,
            'response_date' => $this->response_date?->format('F Y'),
            'social_links' => $this->formatted_social_links,
            'featured' => $this->is_featured,
            'created_at' => $this->created_at?->format('Y-m-d'),
            'updated_at' => $this->updated_at?->format('Y-m-d'),
        ];
    }
}