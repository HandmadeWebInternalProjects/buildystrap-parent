<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Buildystrap\GlobalModuleCache;
use stdClass;

use function call_user_func;
use function optional;

class GlobalModule extends Module
{
    protected int $global_id;
    protected ?Module $global_module;

    public function __construct(stdClass $module)
    {
        $this->uuid = $module->uuid;
        $this->enabled = $module->enabled ?? false;
        $this->type = $module->type;

        $this->global_id = (int) $module->global_id;
        $this->global_module = GlobalModuleCache::get($this->global_id);

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

    public function __call(string $name, $arguments): mixed
    {
        return method_exists($this->global_module, $name) ? call_user_func(
            [$this->global_module, $name],
            $arguments
        ) : null;
    }

    public function render(): string
    {
        return optional($this->global_module)->render() ?? '';
    }
}
