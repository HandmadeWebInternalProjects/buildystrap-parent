<?php

namespace Buildystrap\Traits;

use Buildystrap\Builder\Extends\Module;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use function collect;
use function wp_get_attachment_url;

trait HtmlStyleBuilder
{
  protected array $html_classes = [];
  protected array $inline_styles = [];

  public function classes(string $classes = ''): string
  {
    return $this->getClasses($classes)->implode(' ');
  }

  public function getClasses(string $classes = ''): Collection
  {
    $classes = collect([
      $this instanceof Module ? 'buildystrap-module' : null,
      'buildystrap-' . $this->type(),
      $classes,
    ]);

    return $classes
      ->merge($this->html_classes)
      ->push($this->getAttribute('class', ''))
      ->filter();
    //->map(fn ($class) => Str::lower($class));
  }

  public function inlineStyles(string $inlineStyles = ''): string
  {
    return $this->getInlineStyles($inlineStyles)->push($inlineStyles)->implode(' ');
  }

  public function getInlineStyles(string $inlineStyles = ''): Collection
  {
    return collect($this->inline_styles)
      ->push($inlineStyles)
      ->filter();
    //->map(fn ($style) => Str::lower($style));
  }

  protected function generateClasses(): void
  {
    if (function_exists('get_field')) {
      if ($selected_module_styles = $this->getInlineAttribute('module_styles', null)) {
        $moduleStyles = collect(get_field('buildystrap_module_styles', 'option')['modules']);
        $sharedStyles = collect(get_field('buildystrap_module_styles', 'option')['shared']);
        $styles = collect($moduleStyles->where('module_name', $this->type())->pluck('styles')->first())->merge($sharedStyles);

        if ($styles->isNotEmpty()) {
          $style_classes = $styles->reduce(
            function ($carry, $item) use ($selected_module_styles) {
              if ($item !== false) {
                if (stripos(implode(' ', $selected_module_styles), $item['label']) !== false) {
                  $carry = array_merge($carry, explode(' ', $item['value']));
                }
              }
              return $carry;
            },
            []
          );

          $this->html_classes[] = implode(' ', array_unique($style_classes));
        }
      }
    }


    /** Position */
    foreach ($this->getInlineAttribute('display.position', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "position-{$value}",
        default => "position-{$breakpoint}-{$value}"
      };
    }

    /** Position location (top/bottom etc) */
    foreach ($this->getInlineAttribute('display.attributes', []) as $position => $items) {
      foreach ($items as $breakpoint => $value) {
        $pos = match ($position) {
          'top' => 'top',
          'bottom' => 'bottom',
          'left' => 'start',
          'right' => 'end',
          default => ''
        };

        if (!empty($pos)) {
          $this->html_classes[] = match ($breakpoint) {
            'xs' => "{$pos}-{$value}",
            default => "{$pos}-{$breakpoint}-{$value}"
          };
        }
      }
    }

    /** Flex/Grid */
    foreach ($this->getInlineAttribute('display.property', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "d-{$value}",
        default => "d-{$breakpoint}-{$value}"
      };
    }

    foreach ($this->getInlineAttribute('display.flex-direction', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "flex-{$value}",
        default => "flex-{$breakpoint}-{$value}"
      };
    }

    foreach ($this->getInlineAttribute('display.flex-wrap', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "flex-{$value}",
        default => "flex-{$breakpoint}-{$value}"
      };
    }

    foreach ($this->getInlineAttribute('display.justify-content', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "justify-content-{$value}",
        default => "justify-content-{$breakpoint}-{$value}"
      };
    }

    foreach ($this->getInlineAttribute('display.align-items', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "align-items-{$value}",
        default => "align-items-{$breakpoint}-{$value}"
      };
    }

    foreach ($this->getInlineAttribute('display.align-self', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "align-self-{$value}",
        default => "align-self-{$breakpoint}-{$value}"
      };
    }

    foreach ($this->getInlineAttribute('display.align-content', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "align-content-{$value}",
        default => "align-content-{$breakpoint}-{$value}"
      };
    }

    foreach ($this->getInlineAttribute('display.grid-template-rows', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "grid-template-rows-{$value}",
        default => "grid-template-rows-{$breakpoint}-{$value}"
      };
    }

    foreach ($this->getInlineAttribute('display.grid-template-columns', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "grid-template-columns-{$value}",
        default => "grid-template-columns-{$breakpoint}-{$value}"
      };
    }

    /** Col Gap */
    if (!$this->getInlineAttribute('display.combine-gaps', [])) {
      foreach ($this->getInlineAttribute('display.column-gap', []) as $breakpoint => $value) {
        $is_taggable = is_taggable('box_model_sizing', $value);

        if (!$is_taggable) {
          $this->html_classes[] = match ($breakpoint) {
            'xs' => "gx-{$value}",
            default => "gx-{$breakpoint}-{$value}"
          };
        } else {
          if (!in_array('gx-taggable', $this->html_classes)) {
            $this->html_classes[] = 'gx-taggable';
          }
          $this->inline_styles[] = match ($breakpoint) {
            'xs' => "--gx: {$value};",
            default => "--gx-{$breakpoint}: {$value};"
          };
        }
      }
    }

    /** Row Gap */
    if (!$this->getInlineAttribute('display.combine-gaps', [])) {
      foreach ($this->getInlineAttribute('display.row-gap', []) as $breakpoint => $value) {
        // if (!in_array('row-gap', $this->html_classes)) {
        //   $this->html_classes[] = 'row-gap';
        // }

        $is_taggable = is_taggable('box_model_sizing', $value);

        if (!$is_taggable) {
          $this->html_classes[] = match ($breakpoint) {
            'xs' => "gy-{$value}",
            default => "gy-{$breakpoint}-{$value}"
          };
        } else {
          if (!in_array('gy-taggable', $this->html_classes)) {
            $this->html_classes[] = 'gy-taggable';
          }
          $this->inline_styles[] = match ($breakpoint) {
            'xs' => "--gy: {$value};",
            default => "--gy-{$breakpoint}: {$value};"
          };
        }
      }
    }

    if (!empty($this->getInlineAttribute('display.combine-gaps'))) {
      foreach ($this->getInlineAttribute('display.gap', []) as $breakpoint => $value) {
        $is_taggable = is_taggable('box_model_sizing', $value);

        if (!$is_taggable) {
          $this->html_classes[] = match ($breakpoint) {
            'xs' => "gx-{$value} gy-{$value}",
            default => "gx-{$breakpoint}-{$value} gy-{$breakpoint}-{$value}"
          };
        } else {
          if (!in_array('gap-taggable', $this->html_classes)) {
            $this->html_classes[] = 'gap-taggable';
          }
          $this->inline_styles[] = match ($breakpoint) {
            'xs' => "--gx: {$value}; --gy: {$value};",
            default => "--gx-{$breakpoint}: {$value}; --gx-{$breakpoint}: {$value};"
          };
        }
      }
    }

    /** Order */
    foreach ($this->getInlineAttribute('display.order', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "order-{$value}",
        default => "order-{$breakpoint}-{$value}"
      };
    }

    /** Min Width */
    foreach ($this->getInlineAttribute('sizing.minWidth', []) as $breakpoint => $value) {
      $is_taggable = is_taggable('width', $value);
      if (!$is_taggable) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "min-w-{$value}",
          default => "min-w-{$breakpoint}-{$value}"
        };
      } else {
        if (!in_array('min-width-taggable', $this->html_classes)) {
          $this->html_classes[] = 'min-width-taggable';
        }
        $this->inline_styles[] = match ($breakpoint) {
          'xs' => "--min-width: {$value};",
          default => "--min-width-{$breakpoint}: {$value};"
        };
      }
    }

    /** Width */
    foreach ($this->getInlineAttribute('sizing.width', []) as $breakpoint => $value) {
      $is_taggable = is_taggable('width', $value);
      if (!$is_taggable) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "w-{$value}",
          default => "w-{$breakpoint}-{$value}"
        };
      } else {
        if (!in_array('width-taggable', $this->html_classes)) {
          $this->html_classes[] = 'width-taggable';
        }
        $this->inline_styles[] = match ($breakpoint) {
          'xs' => "--width: {$value};",
          default => "--width-{$breakpoint}: {$value};"
        };
      }
    }

    /** Max Width */
    foreach ($this->getInlineAttribute('sizing.maxWidth', []) as $breakpoint => $value) {
      $is_taggable = is_taggable('width', $value);
      if (!$is_taggable) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "max-w-{$value}",
          default => "max-w-{$breakpoint}-{$value}"
        };
      } else {
        if (!in_array('max-width-taggable', $this->html_classes)) {
          $this->html_classes[] = 'max-width-taggable';
        }
        $this->inline_styles[] = match ($breakpoint) {
          'xs' => "--max-width: {$value};",
          default => "--max-width-{$breakpoint}: {$value};"
        };
      }
    }


    /** Min Height */
    foreach ($this->getInlineAttribute('sizing.minHeight', []) as $breakpoint => $value) {
      $is_taggable = is_taggable('height', $value);
      if (!$is_taggable) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "min-h-{$value}",
          default => "min-h-{$breakpoint}-{$value}"
        };
      } else {
        if (!in_array('min-height-taggable', $this->html_classes)) {
          $this->html_classes[] = 'min-height-taggable';
        }
        $this->inline_styles[] = match ($breakpoint) {
          'xs' => "--min-height: {$value};",
          default => "--min-height-{$breakpoint}: {$value};"
        };
      }
    }

    /** Height */
    foreach ($this->getInlineAttribute('sizing.height', []) as $breakpoint => $value) {
      $is_taggable = is_taggable('height', $value);
      if (!$is_taggable) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "h-{$value}",
          default => "h-{$breakpoint}-{$value}"
        };
      } else {
        if (!in_array('height-taggable', $this->html_classes)) {
          $this->html_classes[] = 'height-taggable';
        }
        $this->inline_styles[] = match ($breakpoint) {
          'xs' => "--height: {$value};",
          default => "--height-{$breakpoint}: {$value};"
        };
      }
    }

    /** Max Height */
    foreach ($this->getInlineAttribute('sizing.maxHeight', []) as $breakpoint => $value) {
      $is_taggable = is_taggable('height', $value);
      if (!$is_taggable) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "max-h-{$value}",
          default => "max-h-{$breakpoint}-{$value}"
        };
      } else {
        if (!in_array('max-height-taggable', $this->html_classes)) {
          $this->html_classes[] = 'max-height-taggable';
        }
        $this->inline_styles[] = match ($breakpoint) {
          'xs' => "--max-height: {$value};",
          default => "--max-height-{$breakpoint}: {$value};"
        };
      }
    }

    /** Margin */
    foreach ($this->getInlineAttribute('margin', []) as $position => $items) {
      foreach ($items as $breakpoint => $value) {
        $pos = match ($position) {
          'top' => 'mt',
          'bottom' => 'mb',
          'left' => 'ms',
          'right' => 'me',
          default => ''
        };

        if (!empty($pos)) {
          $is_taggable = is_taggable('box_model_sizing', $value);

          if (!$is_taggable) {
            $this->html_classes[] = match ($breakpoint) {
              'xs' => "{$pos}-{$value}",
              default => "{$pos}-{$breakpoint}-{$value}"
            };
          } else {
            if (!in_array("${pos}-taggable", $this->html_classes)) {
              $this->html_classes[] = "${pos}-taggable";
            }
            $this->inline_styles[] = match ($breakpoint) {
              'xs' => "--{$pos}: {$value};",
              default => "--{$pos}-{$breakpoint}: {$value};"
            };
          }
        }
      }
    }

    /** Padding */
    // var_dump($this->getInlineAttribute('padding', []));
    foreach ($this->getInlineAttribute('padding', []) as $position => $items) {
      foreach ($items as $breakpoint => $value) {
        $pos = match ($position) {
          'top' => 'pt',
          'bottom' => 'pb',
          'left' => 'ps',
          'right' => 'pe',
          default => ''
        };

        if (!empty($pos)) {
          $is_taggable = is_taggable('box_model_sizing', $value);

          if (!$is_taggable) {
            $this->html_classes[] = match ($breakpoint) {
              'xs' => "{$pos}-{$value}",
              default => "{$pos}-{$breakpoint}-{$value}"
            };
          } else {
            if (!in_array("${pos}-taggable", $this->html_classes)) {
              $this->html_classes[] = "${pos}-taggable";
            }
            $this->inline_styles[] = match ($breakpoint) {
              'xs' => "--{$pos}: {$value};",
              default => "--{$pos}-{$breakpoint}: {$value};"
            };
          }
        }
      }
    }

    // If background separate_element is true, we won't add styles, we'll make a separate div in the view
    if (!$this->getInlineAttribute('background.separate_element', [])) {
      /** Background Image URL */
      foreach ($this->getInlineAttribute('background.image.id', []) as $breakpoint => $value) {
        $imageUrl = collect($value)
          ->take(1)
          ->map(fn ($image) => wp_get_attachment_url($image['id']))
          ->first();

        if (!empty($imageUrl)) {
          $this->inline_styles[] = match ($breakpoint) {
            'xs' => "--bg-image-url: url('{$imageUrl}');",
            default => "--bg-image-url-{$breakpoint}: url('{$imageUrl}');"
          };
        }
      }

      /** Background Image Size */
      foreach ($this->getInlineAttribute('background.image.size', []) as $breakpoint => $value) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "bg-{$value}",
          default => "bg-{$breakpoint}-{$value}"
        };
      }

      /** Background Image Position */
      foreach ($this->getInlineAttribute('background.image.position', []) as $breakpoint => $value) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "bg-{$value}",
          default => "bg-{$breakpoint}-{$value}"
        };
      }

      /** Background Image Repeat */
      foreach ($this->getInlineAttribute('background.image.repeat', []) as $breakpoint => $value) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "bg-{$value}",
          default => "bg-{$breakpoint}-{$value}"
        };
      }

      /** Background Color */
      foreach ($this->getInlineAttribute('background.color', []) as $breakpoint => $value) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "bg-{$value}",
          default => "bg-{$breakpoint}-{$value}"
        };
      }

      /** Background Blend Mode */
      foreach ($this->getInlineAttribute('background.image.blend-mode', []) as $breakpoint => $value) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "bg-blend-{$value}",
          default => "bg-blend-{$breakpoint}-{$value}"
        };
      }
    }

    /** Typography Color */
    foreach ($this->getInlineAttribute('typography.color', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "text-{$value}",
        default => "text-{$breakpoint}-{$value}"
      };
    }

    /** Typography Font Family */
    foreach ($this->getInlineAttribute('typography.font-family', []) as $breakpoint => $value) {
      $is_taggable = !in_array($value, ['serif', 'sans-serif']);

      if (!$is_taggable) {
        $this->html_classes[] = match ($breakpoint) {
          'xs' => "font-family-{$value}",
          default => "font-family-{$breakpoint}-{$value}"
        };
      } else {
        if (!in_array('font-family-taggable', $this->html_classes)) {
          $this->html_classes[] = 'font-family-taggable';
        }
        $this->inline_styles[] = match ($breakpoint) {
          'xs' => "--font-family: {$value};",
          default => "--font-family-{$breakpoint}: {$value};"
        };
      }
    }

    /** Typography Font Weight */
    foreach ($this->getInlineAttribute('typography.font-weight', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "font-{$value}",
        default => "font-{$breakpoint}-{$value}"
      };
    }

    /** Typography Font Size */
    foreach ($this->getInlineAttribute('typography.font-size', []) as $breakpoint => $value) {
      $is_heading = in_array($value, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']);
      $is_display = in_array($value, ['display-1', 'display-2', 'display-3', 'display-4', 'display-5', 'display-6']);

      if ($is_heading || $is_display) {
        if ($is_heading) {
          $this->html_classes[] = match ($breakpoint) {
            'xs' => "fs-{$value}",
            default => "fs-{$breakpoint}-{$value}"
          };
        }
        if ($is_display) {
          $this->html_classes[] = match ($breakpoint) {
            'xs' => "display-" . str_replace('display-', '', $value),
            default => "display-{$breakpoint}-" . str_replace('display-', '', $value)
          };
        }
      } else {
        if (!in_array('fs-taggable', $this->html_classes)) {
          $this->html_classes[] = 'fs-taggable';
        }
        $this->inline_styles[] = match ($breakpoint) {
          'xs' => "--font-size: {$value};",
          default => "--font-size-{$breakpoint}: {$value};"
        };
      }
    }

    /** Typography Line Height */
    foreach ($this->getInlineAttribute('typography.line-height', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "lh-{$value}",
        default => "lh-{$breakpoint}-{$value}"
      };
    }


    /** Typography Text Align */
    foreach ($this->getInlineAttribute('typography.text-align', []) as $breakpoint => $value) {
      $this->html_classes[] = match ($breakpoint) {
        'xs' => "text-{$value}",
        default => "text-{$breakpoint}-{$value}"
      };
    }
  }
}
