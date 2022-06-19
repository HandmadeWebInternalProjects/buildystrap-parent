<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Buildystrap\Builder\Fields\Text as TextField;
use BuildystrapAddons\Fields\Markdown;
use Illuminate\Support\Collection;

class Blurb extends Module
{
    protected function blueprint(): Collection
    {
        return collect([
            // 'text' => TextField::class,
            'text' => [
                'type' => Markdown::class,
            ],
        ]);
    }

    protected function augment()
    {
    }
}
