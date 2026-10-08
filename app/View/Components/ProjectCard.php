<?php

// app/View/Components/ProjectCard.php

namespace App\View\Components;

use Illuminate\View\Component;

class ProjectCard extends Component
{
    /**
     * The project data.
     *
     * @var object|array
     */
    public $project;

    /**
     * The card variant.
     *
     * @var string
     */
    public $variant;

    /**
     * Whether to show category.
     *
     * @var bool
     */
    public $showCategory;

    /**
     * Whether to show excerpt.
     *
     * @var bool
     */
    public $showExcerpt;

    /**
     * Whether to show technologies.
     *
     * @var bool
     */
    public $showTechnologies;

    /**
     * The card aspect ratio.
     *
     * @var string
     */
    public $aspectRatio;

    /**
     * The overlay opacity.
     *
     * @var float
     */
    public $overlayOpacity;

    /**
     * Create a new component instance.
     *
     * @param object|array $project
     * @param string $variant
     * @param bool $showCategory
     * @param bool $showExcerpt
     * @param bool $showTechnologies
     * @param string $aspectRatio
     * @param float $overlayOpacity
     */
    public function __construct(
        $project,
        $variant = 'default',
        $showCategory = true,
        $showExcerpt = false,
        $showTechnologies = false,
        $aspectRatio = '4/5',
        $overlayOpacity = 0.4
    ) {
        $this->project = (object) $project;
        $this->variant = $variant;
        $this->showCategory = $showCategory;
        $this->showExcerpt = $showExcerpt;
        $this->showTechnologies = $showTechnologies;
        $this->aspectRatio = $aspectRatio;
        $this->overlayOpacity = $overlayOpacity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.project-card');
    }

    /**
     * Get the project image URL.
     *
     * @return string
     */
    public function getImageUrl()
    {
        if (isset($this->project->image_url)) {
            return $this->project->image_url;
        }

        if (isset($this->project->image)) {
            return asset($this->project->image);
        }

        return asset('images/projects/placeholder.webp');
    }

    /**
     * Get the project URL.
     *
     * @return string
     */
    public function getProjectUrl()
    {
        if (isset($this->project->slug)) {
            return route('projects.show', $this->project->slug);
        }

        return '#';
    }

    /**
     * Get the card classes based on variant.
     *
     * @return string
     */
    public function getCardClasses()
    {
        $baseClasses = 'group relative overflow-hidden cursor-pointer block';
        
        $variantClasses = match($this->variant) {
            'minimal' => 'bg-gray-900',
            'bordered' => 'border border-white/10',
            'gradient' => 'bg-gradient-to-b from-gray-900 to-black',
            default => 'bg-gray-900'
        };

        return "{$baseClasses} {$variantClasses}";
    }

    /**
     * Get the aspect ratio class.
     *
     * @return string
     */
    public function getAspectRatioClass()
    {
        return match($this->aspectRatio) {
            '1/1' => 'aspect-square',
            '16/9' => 'aspect-video',
            '3/4' => 'aspect-[3/4]',
            '4/3' => 'aspect-[4/3]',
            default => 'aspect-[4/5]'
        };
    }
}