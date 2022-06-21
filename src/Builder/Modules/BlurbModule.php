<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

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
