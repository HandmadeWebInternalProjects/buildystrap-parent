<?php

namespace Buildystrap\Builder;

use Buildystrap\Builder;
use stdClass;

class Column
{
    public $modules;

    public function __construct(stdClass $column)
    {
        $this->modules = collect([]);

        if (!empty($column->modules)) {
            foreach ($column->modules as $module) {
                $enabled = $module->enabled ?? false;

                if ($enabled && $_module = Builder::getModule($module->type)) {
                    $_module = new $_module($module);

                    $this->modules->push($_module);
                }
            }
        }
    }

    public function render()
    {
        return view('builder::column')->with('modules', $this->modules)->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
