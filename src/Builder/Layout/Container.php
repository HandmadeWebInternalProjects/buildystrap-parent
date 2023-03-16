<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Traits\Augment;

use function view;

class Container
{
    use Augment;

    protected array $sections = [];
    protected $global_section_wrapper;

    public function __construct(array $sections, $global_section_wrapper = null)
    {
        $this->global_section_wrapper = $global_section_wrapper;
        foreach ($sections ?? [] as $section) {
            $this->sections[] = match (true) {
                ($section['type'] === 'global-section') => new GlobalSection($section),
                default => new Section($section)
            };
        }
    }

    public function sections(): array
    {
        return $this->sections;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        $this->augmentOnce();

        if ($this->global_section_wrapper) {
            return view('builder::global-container')->with(['container' => $this, 'wrapper' => $this->global_section_wrapper])->render();
        }

        return view('builder::container')->with('container', $this)->render();
    }
}
