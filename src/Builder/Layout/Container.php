<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Traits\Augment;
use Buildystrap\Traits\CollectionClass;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

use function view;

class Container
{
    use Augment;
    use CollectionClass;

    protected Collection|LazyCollection $sections;
    protected $global_section_wrapper;

    public function __construct(array $sections, $global_section_wrapper = null)
    {
        $this->global_section_wrapper = $global_section_wrapper;

        $this->sections = $this->collectionClass($sections)
            ->map(fn ($section) => match (true) {
                ($section['type'] === 'global-section') => new GlobalSection($section),
      ($section['type'] === 'divider-module') => new \Buildystrap\Builder\Modules\DividerModule($section),
                default => new Section($section)
            });
    }

    public function sections(): Collection|LazyCollection
    {
        return $this->sections;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        $this->augmentOnce();

        if ($this->global_section_wrapper) {
            return view('builder::global-container')->with(['container' => $this, 'wrapper' => $this->global_section_wrapper])->render();
        }

        return view('builder::container')->with('container', $this)->render();
    }
}
