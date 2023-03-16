<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

class LinkField extends Field
{

  protected static function blueprint(): array
  {
    return [
      'config' => [
        'display' => 'Link Field',
      ],
    ];
  }

  public function __toString(): string
  {
    return 'Call this field using double curly braces: {{ link_field }}, or create your own markup by saving it to a variable and using the title, url, target values from the array.';
  }

  public function toHtml(): string
  {
    return view('builder.components.linkfield', [
      'data' => $this->value(),
      'class' => $this->additional_classes
    ])->render();
  }
}
