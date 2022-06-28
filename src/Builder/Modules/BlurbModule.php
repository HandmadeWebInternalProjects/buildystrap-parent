<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

use function collect;

class BlurbModule extends Module
{
    protected function augment(): void
    {
    }

    public static function blueprint(): Collection
    {
        return collect([
            'icon' => 'fa-solid fa-anchor',
            'fields' => [
                'title' => [
                    'type' => 'text-field',
                ],
                'url' => [
                    'type' => 'text-field',
                ],
                'content' => [
                    'type' => 'text-field',
                ],
            ],
        ]);
    }
}
