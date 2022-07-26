<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Cache\GlobalSectionCache;
use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Config;
use stdClass;

use function is_iterable;

class GlobalSection
{
    use Attributes;
    use Config;

//    protected ?Container $container;
    protected string $uuid;
    protected string $type;
    protected int $global_id;

    public function __construct(stdClass $global_section)
    {
        $this->uuid = $global_section->uuid;
        $this->type = $global_section->type;

        $this->config = [];
        if (isset($global_section->config) && is_iterable($global_section->config)) {
            $this->config = (array) $global_section->config;
        }

        $this->global_id = $global_section->id;
//        $this->container = GlobalSectionCache::get($global_section->id);
    }

    public function enabled(): bool
    {
        return $this->getFromConfig('enabled', false);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        $this->augmentOnce();

        return GlobalSectionCache::render($this->global_id);
    }

//    public function container(): ?Container
//    {
//        return $this->container;
//    }
}
