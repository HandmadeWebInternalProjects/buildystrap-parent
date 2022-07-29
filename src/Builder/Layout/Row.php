<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;
use Illuminate\Support\Collection;
use stdClass;

use function view;

class Row extends Layout
{
    protected array $columns = [];

    public function __construct(stdClass $row, ?Layout $parent = null)
    {
        parent::__construct($row, $parent);

        foreach ($row->columns ?? [] as $column) {
            $this->columns[] = new Column($column, $this);
        }
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function getClasses(string $classes = ''): Collection
    {
        return parent::getClasses($classes)->push('row');
    }

    public function render(): string
    {
        $this->augmentOnce();

        return view('builder::row')->with('row', $this)->render();
    }
}
