<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Layout;
use Buildystrap\Builder\Modules\GlobalModule;
use stdClass;

use function function_exists;
use function get_field;
use function view;

class Column extends Layout
{
    protected array $modules = [];

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
            /** Figure out default Flex/Grid style */
            $prefix = ''; // Default to Flex
            if (function_exists('get_field') && $grid_defaults = get_field('structure_default_grid_system', 'option')) {
                $prefix = match ($grid_defaults) {
                    'grid' => 'g-', // Grid
                    default => '', // Flex
                };
            }

            if ($this->hasParent()) {
                /** Use Flex/Grid style for this breakpoint from the parent row (if set) */
                $prefix = match (true) {
                    $this->parent()->getClasses()->contains("d-{$breakpoint}-flex") => '', // Flex
                    $this->parent()->getClasses()->contains("d-{$breakpoint}-grid") => 'g-', // Grid
                    $this->parent()->getClasses()->contains('d-flex') => '', // Flex
                    $this->parent()->getClasses()->contains('d-grid') => 'g-', // Grid
                    default => $prefix // Default style from before parent check
                };
            }

            $this->html_classes[] = match ($breakpoint) {
                'xs' => "{$prefix}col-{$value}",
                default => "{$prefix}col-{$breakpoint}-{$value}"
            };
        }
    }
}
