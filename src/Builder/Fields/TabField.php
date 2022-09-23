<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;
use Buildystrap\Str;

use function collect;
use function sprintf;

class TabField extends Field
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
        "<ul class='nav nav-tabs' id='myTab' role='tablist'>%s</ul>",
        collect($this->value())->map(function ($el, $i) {
          $title = $el['title'] ?? '';
          $id = Str::slug($title);
          $active = $i === 0 ? 'active' : '';
          return
            "<li class='nav-item' role='presentation'>
                <button 
                class='nav-link {$active}' 
                id='{$id}-tab' 
                data-bs-toggle='tab' 
                data-bs-target='#{$id}-tab-pane' 
                type='button' 
                role='tab' 
                aria-controls='{$id}-tab-pane' 
                aria-selected='true'>" . esc_html__($title, 'buildystrap') . "</button>
              </li>";
        })->implode(' ')
      ) .
      sprintf(
        "<div class='tab-content' id='myTabContent'>%s</div>",
        collect($this->value())->map(function ($el, $i) {
          $title = $el['title'] ?? '';
          $content = $el['content'] ?? '';
          $id = Str::slug($title);
          $active = $i === 0 ? 'show active' : '';
          return "<div 
            class='tab-pane py-4 fade {$active}' 
            id='{$id}-tab-pane' 
            role='tabpanel' 
            aria-labelledby='{$id}-tab' 
            tabindex='0'>" . __($content, 'buildystrap') . "</div>";
        })->implode(' ')
      );
  }
}
