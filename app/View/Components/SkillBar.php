<?php

// app/View/Components/SkillBar.php

namespace App\View\Components;

use Illuminate\View\Component;

class SkillBar extends Component
{
    /**
     * The skill name.
     *
     * @var string
     */
    public $name;

    /**
     * The skill level (0-100).
     *
     * @var int
     */
    public $level;

    /**
     * The skill category.
     *
     * @var string|null
     */
    public $category;

    /**
     * Whether to show percentage.
     *
     * @var bool
     */
    public $showPercentage;

    /**
     * Whether to animate.
     *
     * @var bool
     */
    public $animated;

    /**
     * The bar color.
     *
     * @var string
     */
    public $color;

    /**
     * The animation duration in milliseconds.
     *
     * @var int
     */
    public $duration;

    /**
     * The bar height.
     *
     * @var string
     */
    public $height;

    /**
     * Create a new component instance.
     *
     * @param string|object $name
     * @param int|null $level
     * @param string|null $category
     * @param bool $showPercentage
     * @param bool $animated
     * @param string $color
     * @param int $duration
     * @param string $height
     */
    public function __construct(
        $name,
        $level = null,
        $category = null,
        $showPercentage = true,
        $animated = true,
        $color = 'white',
        $duration = 1000,
        $height = '1px'
    ) {
        // If first parameter is an object/array, extract values from it
        if (is_object($name) || is_array($name)) {
            $data = (object) $name;
            $this->name = $data->name ?? '';
            $this->level = $data->level ?? 0;
            $this->category = $data->category ?? null;
        } else {
            $this->name = $name;
            $this->level = $level ?? 0;
            $this->category = $category;
        }

        $this->showPercentage = $showPercentage;
        $this->animated = $animated;
        $this->color = $color;
        $this->duration = $duration;
        $this->height = $height;

        // Ensure level is between 0 and 100
        $this->level = max(0, min(100, $this->level));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.skill-bar');
    }

    /**
     * Get the level category text.
     *
     * @return string
     */
    public function getLevelCategory()
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
     * Get the level color class.
     *
     * @return string
     */
    public function getLevelColorClass()
    {
        return match(true) {
            $this->level >= 90 => 'from-emerald-400 to-emerald-300',
            $this->level >= 70 => 'from-blue-400 to-blue-300',
            $this->level >= 50 => 'from-yellow-400 to-yellow-300',
            $this->level >= 30 => 'from-orange-400 to-orange-300',
            default => 'from-gray-400 to-gray-300',
        };
    }

    /**
     * Get the animation delay based on index.
     *
     * @param int $index
     * @return int
     */
    public function getAnimationDelay($index = 0)
    {
        return $index * 100; // 100ms delay between each bar
    }

    /**
     * Get the bar styles.
     *
     * @return string
     */
    public function getBarStyles()
    {
        $styles = [];
        
        if ($this->animated) {
            $styles[] = "width: {$this->level}%";
            $styles[] = "transition: width {$this->duration}ms ease-out";
        } else {
            $styles[] = "width: {$this->level}%";
        }

        if ($this->color !== 'white') {
            $styles[] = "background-color: {$this->color}";
        }

        return implode('; ', $styles);
    }
}