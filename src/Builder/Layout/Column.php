<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder;
use Buildystrap\Builder\Extends\Layout;
use stdClass;

use function view;

class Column extends Layout
{
    public array $modules = [];

    public function __construct(stdClass $column)
    {
        parent::__construct($column);

        foreach ($column->modules ?? [] as $module) {
            $moduleType = Builder::getModule($module->type);
            $this->modules[] = new $moduleType($module);
        }
    }

    public function modules(): array
    {
        return $this->modules;
    }

    public function render(): string
    {
        return view('builder::column')->with('column', $this)->render();
    }
}
