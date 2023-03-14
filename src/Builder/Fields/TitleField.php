<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;
use function sprintf;

class TitleField extends Field
{

  protected static function blueprint(): array
  {
    return [
      'config' => [
        'label' => 'Heading',
        'tinymce' => [
          'toolbar1' => 'bold,italic,underline,styleselect',
          'toolbar2' => false,
          'height' => '40',
          'autoresize_min_height' => false,
          'resize' => false,
          'menubar' => false,
          'statusbar' => false,
          'forced_root_block' => false,
        ],
      ],
    ];
  }

  public function augment(): void
  {
    $this->value = collect((array) $this->raw);
  }

  public function titleClass(string $class): static
  {
    $this->additional_classes = $class;
    return $this;
  }

  public function __toString()
  {
    return $this->value()->get('text', '');
  }

  public function toHtml(): string
  {
    return view('builder.components.title')->with([
      "title" => [
        "level" => $this->value()->get('level'),
        "text" => $this->value()->get('text', ''),
        "size" => $this->value()->get('size', []),
        "color" => $this->value()->get('color', []),
        "weight" => $this->value()->get('weight', []),
        "class" => $this->value()->get('class', '') . ' ' . ($this->additional_classes ?? ''),
      ]
    ])->render();
  }
}
