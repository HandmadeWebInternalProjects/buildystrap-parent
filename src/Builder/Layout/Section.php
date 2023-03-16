<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

use function view;

class Section extends Layout
{
    protected Collection|LazyCollection $rows;

    public function __construct(array $section, ?Layout $parent = null)
    {
        parent::__construct($section, $parent);

        $this->rows = $this->collectionClass($section['rows'])
            ->map(fn ($row) => new Row($row, $this));
    }

    public function rows(): Collection|LazyCollection
    {
        return $this->rows;
    }

    public function render(): string
    {
        $this->augmentOnce();

        return view('builder::section')->with('section', $this)->render();
    }
}
