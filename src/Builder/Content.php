<?php

namespace Buildystrap\Builder;

use Buildystrap\Builder\Layout\Container;

use function json_decode;

class Content
{
    protected Container $container;

    public function __construct(string $content, $global_section_wrapper = null)
    {
        $sections = json_decode($content, true) ?? [];

        $this->container = new Container($sections, $global_section_wrapper);
    }

    public function container(): Container
    {
        return $this->container;
    }
}
