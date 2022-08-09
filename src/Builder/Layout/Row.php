<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;
use Buildystrap\Str;
use Illuminate\Support\Collection;

use function get_field;
use function view;

class Row extends Layout
{
    protected array $columns = [];

    public function __construct(array $row, ?Layout $parent = null)
    {
        parent::__construct($row, $parent);

        foreach ($row['columns'] ?? [] as $column) {
            $this->columns[] = new Column($column, $this);
        }
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function render(): string
    {
        $this->augmentOnce();

        return view('builder::row')->with('row', $this)->render();
    }

    protected function generateClasses(): void
    {
        parent::generateClasses();

        // Check if the row has an override for flex / grid specifically
        $hasClassOverride = $this->getClasses()->filter(function ($class) {
            return Str::contains($class, ['-flex', '-grid']);
        })->isNotEmpty();

        // If it does, don't add the default flex / grid classes
        if ($hasClassOverride) {
            return;
        }

        $class = '';

        // Add grid or d-flex onto the row based on the grid system default
        if (function_exists('get_field') && $grid_defaults = get_field(
            'buildystrap_structure_default_grid_system',
            'option'
        )) {
            $class = match ($grid_defaults) {
                'grid' => 'grid', // Grid
                default => 'd-flex', // Flex
            };
        }

        $this->html_classes['xs'] = $class;
    }

    public function getClasses(string $classes = ''): Collection
    {
        return parent::getClasses($classes)->push('row');
    }
}
