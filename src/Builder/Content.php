<?php

namespace Buildystrap\Builder;

use Buildystrap\Builder\Layout\Container;

use function json_decode;

class Content
{
    protected Container $container;

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
