<?php

namespace Buildystrap\Builder;

use stdClass;

class Row
{
    public $columns;

    public function __construct(stdClass $row)
    {
        $this->columns = collect([]);

        if (!empty($row->columns)) {
            foreach ($row->columns as $column) {
                if ($column->enabled ?? false) {
                    $item = new Column($column);

                    $this->columns->push($item);
                }
            }
        }
    }

    public function render()
    {
        return view('builder::row')->with('columns', $this->columns)->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
