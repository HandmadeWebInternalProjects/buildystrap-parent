<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Traits\Augment;

use function view;

class Container
{
    use Augment;

    protected array $sections = [];

    public function __construct(array $sections)
    {
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

        return view('builder::container')->with('container', $this)->render();
    }
}
