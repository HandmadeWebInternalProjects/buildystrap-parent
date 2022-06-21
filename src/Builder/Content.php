<?php

namespace Buildystrap\Builder;

use Buildystrap\Builder\Layout\Container;

class Content
{
    public Container $container;

    public function __construct(string $content)
    {
        $sections = json_decode($content) ?? [];

        $this->container = new Container($sections);
    }

    public function container(): Container
    {
        return $this->container;
    }
}
