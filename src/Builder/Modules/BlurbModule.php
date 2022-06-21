<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

use function collect;

class BlurbModule extends Module
{
    protected function blueprint(): Collection
    {
        return collect([
            'text' => [
                'type' => 'text-field',
            ],
        ]);
    }

    protected function augment(): void
    {
    }
}
