<?php

namespace Buildystrap\Builder\Layout;

use Buildystrap\Builder\Extends\Layout;
use Buildystrap\Cache\GlobalModuleCache;
use Buildystrap\Cache\GlobalSectionCache;

class GlobalSection extends Layout
{
    protected array $rows = [];
    public int $global_id;

    public function __construct(array $global_section, ?Layout $parent = null)
    {
        parent::__construct($global_section, $parent);

        $this->global_id = $global_section['global_id'];
    }

    public function render(): string
    {
        $this->augmentOnce();

        // We can actually use global modules here if we want to bypass something being nested inside a section > row > column
        // This is a hidden feature in the GUI and requires holding CTRL and clicking the title when viewing global sections to reveal modules
        $global = GlobalSectionCache::get($this->global_id, $this) ?? GlobalModuleCache::get($this->global_id, $this);

        return isset($global) ? $global->render() : '';
    }
}
