<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;

class Container extends Layout
{
    protected array $sections = [];

    public function __construct($container)
    {
        parent::__construct($container);

        foreach ($container->sections ?? [] as $section) {
            $this->sections[] = new Section($section);
        }
    }

    public function sections(): array
    {
        return $this->sections;
    }

    public function render(): string
    {
        return view('builder::container')->with('container', $this)->render();
    }
}
