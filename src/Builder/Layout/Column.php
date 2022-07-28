<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Layout;
use Buildystrap\Builder\Modules\GlobalModule;
use stdClass;

use function view;

class Column extends Layout
{
    protected array $modules = [];

    public function __construct(stdClass $column)
    {
        parent::__construct($column);



        foreach ($column->modules ?? [] as $module) {
            // Global module
            $moduleType = $module->type === 'global-module' ? GlobalModule::class : Builder::getModule($module->type);

            $this->modules[] = new $moduleType($module);

            // Or
            // Convert Global module to the end module
//            if ($module->type === 'global-module' && $globalModule = Builder::getGlobalModule($module->global_id)) {
//                $this->modules[] = $globalModule;
//            } else {
//                $moduleType = Builder::getModule($module->type);
//
//                $this->modules[] = new $moduleType($module);
//            }
        }
    }

    public function modules(): array
    {
        return $this->modules;
    }

    public function render(): string
    {
        $this->augmentOnce();

        return view('builder::column')->with('column', $this)->render();
    }
}
