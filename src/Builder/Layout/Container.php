<?php

namespace Buildystrap\Builder\Layout;

use function view;

class Container
{
    protected array $sections = [];

    public function __construct(array $sections)
    {
        foreach ($sections ?? [] as $section) {
            if ($section->type === 'section') {
                $this->sections[] = new Section($section);
            } elseif ($section->type === 'global-section') {
                $this->sections[] = new GlobalSection($section);
            }
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
        return view('builder::container')->with('container', $this)->render();
    }
}
