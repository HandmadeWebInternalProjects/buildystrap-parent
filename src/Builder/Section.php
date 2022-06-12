<?php

namespace Buildystrap\Builder;

use stdClass;

class Section
{
    public $rows;

    public function __construct(stdClass $section)
    {
        $this->rows = collect([]);

        if (!empty($section->rows)) {
            foreach ($section->rows as $row) {
                if ($row->enabled ?? false) {
                    $item = new Row($row);

                    $this->rows->push($item);
                }
            }
        }
    }

    public function render()
    {
        return view('builder::section')->with('rows', $this->rows)->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
