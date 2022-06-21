<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;

class Blurb extends Module
{
    protected function blueprint(): Collection
    {
        return collect([
            'text' => [
                'type' => 'text-fieldtype',
            ],
        ]);
    }

    protected function augment()
    {
    }
}
