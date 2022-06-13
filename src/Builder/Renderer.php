<?php

namespace Buildystrap\Builder;

use Buildystrap\Builder\Layout\Container;

class Renderer
{
    public Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function render(): string
    {
        return $this->container->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
