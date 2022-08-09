<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;
use Buildystrap\Str;

use function collect;
use function sprintf;

class AccordionField extends Field
{
    protected static function blueprint(): array
    {
        return [
            'config' => [],
        ];
    }

    public function __toString(): string
    {
        return
            sprintf(
                '<div class=\'accordion\'>%s</div>',
                collect($this->value())->map(function ($el, $i) {
                    $title = $el['title'];
                    $content = $el['content'];
                    $id = Str::slug($title);
                    return sprintf(
                        "
          <div class='accordion-item'>
            <h2 class='accordion-header' id='buildystrap-accordion-item-{$id}-{$i}'>
              <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#buildystrap-accordion-item-collapse-{$id}-{$i}' aria-expanded='false' aria-controls='buildystrap-accordion-item-collapse-{$id}-{$i}'>
                %s
              </button>
            </h2>
            <div id='buildystrap-accordion-item-collapse-{$id}-{$i}' class='accordion-collapse collapse' aria-labelledby='buildystrap-accordion-item-{$id}-{$i}' data-bs-parent='#accordionbuildystrap-accordion-itemExample'>
              <div class='accordion-body'>%s</div>
            </div>
          </div>",
                        $title,
                        $content
                    );
                })->implode(' ')
            );
    }
}
