<?php

namespace Buildystrap\Builder\Layout;

class Container
{
    protected array $sections = [];

    public function __construct(array $sections)
    {
        foreach ($sections ?? [] as $section) {
            $this->sections[] = new Section($section);
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
