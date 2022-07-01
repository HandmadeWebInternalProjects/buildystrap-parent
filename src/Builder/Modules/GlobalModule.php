<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Module;
use stdClass;

class GlobalModule extends Module
{
    protected $global_id;

    public function __construct(stdClass $module)
    {
        $this->uuid = $module->uuid;
        $this->enabled = $module->enabled ?? false;
        $this->type = $module->type;

        $this->augment();

        $this->global_id = $module->global_id;
    }

    protected static function blueprint(): array
    {
        return [
            'icon' => 'fa-solid fa-anchor',
        ];
    }

    public function render(): string
    {
        return optional(Builder::getGlobalModule($this->global_id))->render() ?? '';
    }

    protected function augment(): void
    {
    }
}
