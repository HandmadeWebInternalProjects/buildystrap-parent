<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;
use Buildystrap\Builder\Layout\Section;

class SectionField extends Field
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

  public function __construct(array $field)
  {
    parent::__construct($field);

    $section = new Section($field);

    // Since this is nested we don't want to have another container inside.
    $section->setConfig('boxed_layout', false);

    $this->value = "<div class='section-field'>" . $section->render() . "</div>";
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
