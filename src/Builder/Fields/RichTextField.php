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

    // Process Shortcodes
    $this->value = apply_shortcodes($this->value);

    // Process Merge Tags
    $this->value = self::process_merge_tags($this->value);
  }
}
