<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Layout;
use Buildystrap\Builder\Modules\GlobalModule;
use stdClass;

use function dd;
use function view;

class Column extends Layout
{
    protected array $modules = [];
    protected array $html_classes = [];

    public function __construct(stdClass $column, ?Layout $parent = null)
    {
        parent::__construct($column, $parent);

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

    public function augment(): void
    {
        $this->generateClasses();
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

    protected function generateClasses(): void
    {
        parent::generateClasses();

        /** Flex/Grid Column Sizes */
        foreach ($this->getConfig('columnSizes', []) as $breakpoint => $value) {
            $prefix = '';

            if ($this->hasParent()) {
                $prefix = match (true) {
                    $this->parent()->getClasses()->contains("d-{$breakpoint}-grid") => 'g-',
                    $this->parent()->getClasses()->contains('d-grid') => 'g-',
                    default => ''
                };
            }

            $this->html_classes[] = match ($breakpoint) {
                'xs' => "{$prefix}col-{$value}",
                default => "{$prefix}col-{$breakpoint}-{$value}"
            };
        }
    }
}
