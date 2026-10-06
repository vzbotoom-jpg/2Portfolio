<?php

// app/View/Components/Navbar.php

namespace App\View\Components;

use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * The logo text.
     *
     * @var string
     */
    public $logo;

    /**
     * The logo image URL.
     *
     * @var string|null
     */
    public $logoImage;

    /**
     * The navigation items.
     *
     * @var array
     */
    public $navItems;

    /**
     * Whether navbar is transparent.
     *
     * @var bool
     */
    public $transparent;

    /**
     * Whether to show the CTA button.
     *
     * @var bool
     */
    public $showCta;

    /**
     * The CTA button text.
     *
     * @var string
     */
    public $ctaText;

    /**
     * The CTA button link.
     *
     * @var string
     */
    public $ctaLink;

    /**
     * Whether navbar is sticky.
     *
     * @var bool
     */
    public $sticky;

    /**
     * The navbar variant.
     *
     * @var string
     */
    public $variant;

    /**
     * Create a new component instance.
     *
     * @param string $logo
     * @param string|null $logoImage
     * @param array|null $navItems
     * @param bool $transparent
     * @param bool $showCta
     * @param string $ctaText
     * @param string $ctaLink
     * @param bool $sticky
     * @param string $variant
     */
    public function __construct(
        $logo = 'PORTFOLIO',
        $logoImage = null,
        $navItems = null,
        $transparent = true,
        $showCta = true,
        $ctaText = 'HIRE ME',
        $ctaLink = null,
        $sticky = true,
        $variant = 'default'
    ) {
        $this->logo = $logo;
        $this->logoImage = $logoImage;
        $this->transparent = $transparent;
        $this->showCta = $showCta;
        $this->ctaText = $ctaText;
        $this->ctaLink = $ctaLink ?? route('contact.index');
        $this->sticky = $sticky;
        $this->variant = $variant;

        // Set default navigation items
        $this->navItems = $navItems ?? [
            [
                'label' => 'PROJECTS',
                'url' => route('projects.index'),
                'active' => request()->routeIs('projects.*'),
                'children' => []
            ],
            [
                'label' => 'ABOUT',
                'url' => route('about'),
                'active' => request()->routeIs('about'),
                'children' => []
            ],
            [
                'label' => 'SERVICES',
                'url' => route('services') ?? '#services',
                'active' => request()->routeIs('services'),
                'children' => []
            ],
            [
                'label' => 'CONTACT',
                'url' => route('contact.index'),
                'active' => request()->routeIs('contact'),
                'children' => []
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.partials.navbar');
    }

    /**
     * Check if a nav item is active.
     *
     * @param array $item
     * @return bool
     */
    public function isActive($item)
    {
        if (isset($item['active'])) {
            return $item['active'];
        }

        return request()->url() === $item['url'];
    }

    /**
     * Get the navbar classes based on variant.
     *
     * @return string
     */
    public function navbarClasses()
    {
        $classes = [];
        
        if ($this->sticky) {
            $classes[] = 'fixed top-0 left-0 right-0 z-50';
        }

        if ($this->transparent) {
            $classes[] = 'bg-transparent';
        } else {
            $classes[] = 'bg-black';
        }

        $classes[] = 'transition-all duration-500';

        return implode(' ', $classes);
    }
}