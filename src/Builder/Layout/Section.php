<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;

use function view;

class Section extends Layout
{
    protected array $rows = [];

    public function __construct(array $section, ?Layout $parent = null)
    {
        parent::__construct($section, $parent);

        foreach ($section['rows'] ?? [] as $row) {
            $this->rows[] = new Row($row, $this);
        }
    }

    public function rows(): array
    {
        return $this->rows;
    }

    public function render(): string
    {
        $this->augmentOnce();

        return view('builder::section')->with('section', $this)->render();
    }
}
