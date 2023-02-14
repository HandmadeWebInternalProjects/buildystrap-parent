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
                'input_type' => 'text',
            ],
        ];
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function augment(): void
    {
        parent::augment();
        if (is_string($this->value)) {
            $this->value = apply_shortcodes($this->value);
        }        
    }
}
