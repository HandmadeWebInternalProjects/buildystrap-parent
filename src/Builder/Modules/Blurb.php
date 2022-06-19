<?php

namespace Buildystrap\Builder\Modules;

use Buildystrap\Builder\Extends\Module;
use Buildystrap\Builder\Fields\Text as TextField;
use BuildystrapAddons\Fields\Markdown;

class Blurb extends Module
{
    protected function blueprint(): array
    {
        return [
            'text' => TextField::class,
            // 'text' => Markdown::class,
        ];
    }

    protected function augment()
    {
    }
}
