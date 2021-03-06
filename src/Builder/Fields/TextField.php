<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class TextField extends Field
{
    protected static function blueprint(): array
    {
        return [
            'config' => [
                'display' => 'Text Field',
                'input_type' => 'email',
            ],
        ];
    }

    protected function augment(): void
    {
    }
}
