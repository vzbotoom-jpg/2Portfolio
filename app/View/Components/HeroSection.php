<?php

// app/View/Components/HeroSection.php

namespace App\View\Components;

use Illuminate\View\Component;

class HeroSection extends Component
{
    /**
     * The hero section title.
     *
     * @var string
     */
    public $title;

    /**
     * The hero section subtitle.
     *
     * @var string
     */
    public $subtitle;

    /**
     * The hero section description.
     *
     * @var string|null
     */
    public $description;

    /**
     * The background image URL.
     *
     * @var string|null
     */
    public $backgroundImage;

    /**
     * The background video URL.
     *
     * @var string|null
     */
    public $backgroundVideo;

    /**
     * The overlay opacity.
     *
     * @var float
     */
    public $overlayOpacity;

    /**
     * The primary CTA data.
     *
     * @var array|null
     */
    public $primaryCta;

    /**
     * The secondary CTA data.
     *
     * @var array|null
     */
    public $secondaryCta;

    /**
     * Whether to show scroll indicator.
     *
     * @var bool
     */
    public $showScrollIndicator;

    /**
     * Whether to enable particle effects.
     *
     * @var bool
     */
    public $particles;

    /**
     * The hero section height.
     *
     * @var string
     */
    public $height;

    /**
     * The text alignment.
     *
     * @var string
     */
    public $alignment;

    /**
     * Create a new component instance.
     *
     * @param array|object $data
     * @param string|null $title
     * @param string|null $subtitle
     * @param string|null $description
     * @param string|null $backgroundImage
     * @param string|null $backgroundVideo
     * @param float $overlayOpacity
     * @param array|null $primaryCta
     * @param array|null $secondaryCta
     * @param bool $showScrollIndicator
     * @param bool $particles
     * @param string $height
     * @param string $alignment
     */
    public function __construct(
        $data = null,
        $title = null,
        $subtitle = null,
        $description = null,
        $backgroundImage = null,
        $backgroundVideo = null,
        $overlayOpacity = 0.5,
        $primaryCta = null,
        $secondaryCta = null,
        $showScrollIndicator = true,
        $particles = false,
        $height = 'screen',
        $alignment = 'center'
    ) {
        // If data array/object is provided, extract values from it
        if ($data) {
            $data = (object) $data;
            $this->title = $data->title ?? $title ?? 'CREATING THE FUTURE';
            $this->subtitle = $data->subtitle ?? $subtitle ?? 'Full-Stack Developer & Digital Architect';
            $this->description = $data->description ?? $description;
            $this->backgroundImage = $data->background['image'] ?? $backgroundImage;
            $this->backgroundVideo = $data->background['video'] ?? $backgroundVideo;
            $this->overlayOpacity = $data->background['overlay_opacity'] ?? $overlayOpacity;
            $this->primaryCta = $data->cta_primary ?? $primaryCta;
            $this->secondaryCta = $data->cta_secondary ?? $secondaryCta;
        } else {
            $this->title = $title ?? 'CREATING THE FUTURE';
            $this->subtitle = $subtitle ?? 'Full-Stack Developer & Digital Architect';
            $this->description = $description;
            $this->backgroundImage = $backgroundImage;
            $this->backgroundVideo = $backgroundVideo;
            $this->overlayOpacity = $overlayOpacity;
            $this->primaryCta = $primaryCta;
            $this->secondaryCta = $secondaryCta;
        }

        $this->showScrollIndicator = $showScrollIndicator;
        $this->particles = $particles;
        $this->height = $height;
        $this->alignment = $alignment;

        // Set default CTAs if not provided
        if (!$this->primaryCta) {
            $this->primaryCta = [
                'text' => 'VIEW PROJECTS',
                'link' => route('projects.index'),
            ];
        }

        if (!$this->secondaryCta) {
            $this->secondaryCta = [
                'text' => 'LEARN MORE',
                'link' => route('about'),
            ];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sections.hero-section');
    }

    /**
     * Get the background style attribute.
     *
     * @return string
     */
    public function backgroundStyle()
    {
        if ($this->backgroundImage) {
            return "background-image: url('" . asset($this->backgroundImage) . "')";
        }
        return '';
    }

    /**
     * Get the overlay style attribute.
     *
     * @return string
     */
    public function overlayStyle()
    {
        return "background: rgba(0, 0, 0, {$this->overlayOpacity})";
    }

    /**
     * Get the height class.
     *
     * @return string
     */
    public function heightClass()
    {
        return match($this->height) {
            'full' => 'min-h-full',
            'screen' => 'min-h-screen',
            'auto' => 'min-h-auto',
            default => 'min-h-screen'
        };
    }

    /**
     * Get the alignment class.
     *
     * @return string
     */
    public function alignmentClass()
    {
        return match($this->alignment) {
            'left' => 'text-left',
            'right' => 'text-right',
            default => 'text-center'
        };
    }
}