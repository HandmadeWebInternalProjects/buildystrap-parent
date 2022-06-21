<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;
use stdClass;

use function view;

class Section extends Layout
{
    public array $rows = [];

    public function __construct(stdClass $section)
    {
        parent::__construct($section);

        foreach ($section->rows ?? [] as $row) {
            $this->rows[] = new Row($row);
        }
    }

    public function rows(): array
    {
        return $this->rows;
    }

    public function render(): string
    {
        return view('builder::section')->with('section', $this)->render();
    }
}
