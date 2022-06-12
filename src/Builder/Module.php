<?php

namespace Buildystrap\Builder;

use stdClass;

abstract class Module
{
    public string $type;
    public $value;

    public function __construct(stdClass $module)
    {
        $this->type = $module->type;
        $this->value = $module->value;
    }

    public function augment()
    {
        $this->raw = $this->value;
        $this->value = $this->value();

        return $this;
    }

    public function value()
    {
        return $this->value;
    }

    public function render()
    {
        $views = [
            "builder-modules::{$this->type}",
            'builder::moduleNotFound'
        ];

        return view()->first($views)->with('module', $this->augment())->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
