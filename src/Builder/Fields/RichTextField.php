<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class RichTextField extends Field
{
    protected static function blueprint(): array
    {
        return [
            'config' => [],
        ];
    }
    public function augment(): void
    {
        parent::augment();
        $this->value = apply_shortcodes($this->value);
    }
}
