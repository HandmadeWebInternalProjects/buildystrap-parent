<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;
use stdClass;

class Row extends Layout
{
    public array $columns = [];

    public function __construct(stdClass $row)
    {
        parent::__construct($row);

        foreach ($row->columns ?? [] as $column) {
            $this->columns[] = new Column($column);
        }
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function render(): string
    {
        return view('builder::row')->with('row', $this)->render();
    }
}
