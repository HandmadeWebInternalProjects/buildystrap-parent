<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

use function collect;

class ReplicatorModule extends Module
{
    protected function augment(): void
    {
    }

    public static function blueprint(): Collection
    {
        return collect([
            'icon' => 'fa-solid fa-anchor',
            'fields' => [
                'text' => [
                    'type' => 'text-field',
                ],
            ],
        ]);
    }
}
