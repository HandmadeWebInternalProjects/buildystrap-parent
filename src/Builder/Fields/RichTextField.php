<?php

namespace Buildystrap\Builder\Fields;

class RichTextField extends TextField
{
    public function augment(): void
    {
        parent::augment();
        $this->value = apply_shortcodes($this->value);
    }
}
