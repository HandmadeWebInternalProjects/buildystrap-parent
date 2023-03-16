<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Layout;
use Buildystrap\Builder\Modules\GlobalModule;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

use function function_exists;
use function get_field;
use function view;

class Column extends Layout
{
    protected Collection|LazyCollection $modules;

    public function __construct(array $column, ?Layout $parent = null)
    {
        parent::__construct($column, $parent);

        $this->modules = $this->collectionClass($column['modules'] ?? [])
            ->map(function ($module) {
                // Convert Global module to the end module
//                if ($module['type'] === 'global-module' && $globalModule = Builder::getGlobalModule($module['global_id'])) {
//                    return $globalModule;
//                }

                $moduleType = match (true) {
                    ($module['type'] === 'global-module') => GlobalModule::class,
                    ($module['type'] === 'row') => Row::class,
                    default => Builder::getModule($module['type'])
                };

                return new $moduleType($module);
            });
    }

    public function modules(): Collection|LazyCollection
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

        $columnSizes = $this->getConfig('columnSizes', []);


        /** Figure out default Flex/Grid style */
        $prefix = ''; // Default to Flex
        if (function_exists('get_field') && $grid_defaults = get_field(
            'buildystrap_structure_default_grid_system',
            'option'
        )) {
            $prefix = match ($grid_defaults) {
                'grid' => 'g-', // Grid
                default => '', // Flex
            };
        }



        if ( ! isset($columnSizes['xs'])) {
            $this->html_classes['xs'] = "{$prefix}col-12";
        }


        /** Flex/Grid Column Sizes */
        foreach ($columnSizes as $breakpoint => $value) {
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

            if ($this->getInlineAttribute('moduleGap', [])) {
                $this->html_classes['xs'] .= ' mg-' . $this->getInlineAttribute('moduleGap', []);
            }
        }
    }
}
