<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;
use function sprintf;

class ButtonField extends Field
{
    protected string $title_class = '';
    protected string $button_class = '';

    protected static function blueprint(): array
    {
        return [
          'config' => [
            'sizes' => [
              'Small' => 'btn-sm',
              'Large' => 'btn-lg',
            ],
            'types' => [
              'Primary' => 'btn-primary',
              'Secondary' => 'btn-secondary',
              'Tertiary' => 'btn-tertiary',
              'Warning' => 'btn-warning',
              'Danger' => 'btn-danger',
              'Success' => 'btn-success',
              'Info' => 'btn-info',
              'Unstyled' => 'btn-unstyled',
              'Link' => 'btn-link',
            ]
          ],
        ];
    }

    public function augment(): void
    {
        $this->value = collect((array) $this->raw);
    }

    public function __toString(): string
    {
        return view('builder.components.button', ['button' => $this->value()])->render();
    }
}
