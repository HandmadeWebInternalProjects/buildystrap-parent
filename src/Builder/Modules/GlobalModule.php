<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Buildystrap\Cache\GlobalModuleCache;
use stdClass;

use function call_user_func;

class GlobalModule extends Module
{
    protected int $global_id;

    public function __construct(stdClass $module)
    {
        $this->uuid = $module->uuid;
        $this->enabled = $module->enabled ?? false;
        $this->type = $module->type;

        $this->global_id = (int) $module->global_id;

        $this->augment();
    }

    protected function augment(): void
    {
    }

    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-earth-oceania',
        ];
    }

    public function render(): string
    {
        return GlobalModuleCache::render($this->global_id);
    }
}
