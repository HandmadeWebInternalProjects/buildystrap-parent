<?php

namespace Buildystrap\Builder\Extends;

use Buildystrap\Traits\Attributes;
use Buildystrap\Traits\Augment;
use Buildystrap\Traits\CollectionClass;
use Buildystrap\Traits\Config;
use Buildystrap\Traits\HtmlStyleBuilder;
use Buildystrap\Traits\InlineAttributes;
use Buildystrap\Traits\Visibility;

use function is_array;

abstract class Layout
{
  use Attributes;
  use Augment;
  use Config;
  use CollectionClass;
  use InlineAttributes;
  use HtmlStyleBuilder;
  use Visibility;

  protected string $uuid;
  protected string $type;
  protected ?Layout $parent;

  public function __construct(array $instance, ?Layout $parent = null)
  {
    $this->parent = $parent;
    $this->uuid = $instance['uuid'];
    $this->type = $instance['type'];

    if (isset($instance['config']) && is_array($instance['config'])) {
      $this->config = $instance['config'];
    }

    if (isset($instance['attributes']) && is_array($instance['attributes'])) {
      $this->attributes = $instance['attributes'];
    }

    if (isset($instance['inline']) && is_array($instance['inline'])) {
      $this->inline_attributes = $instance['inline'];
    }

    //Visibility
    if ($visibility = $this->getConfig('visibility')) {
      foreach ($visibility as $breakpoint) {
        $this->visibility_classes[] = "hide-{$breakpoint}";
      }
      array_push($this->html_classes, ...$this->visibility_classes);
    }
  }

  public function addClass(string $class): void
  {
    $this->html_classes[] = $class;
  }

  public function type(): string
  {
    return $this->type;
  }

  public function augment(): void
  {
    $this->generateClasses();
  }

  public function enabled(): bool
  {
    return $this->getConfig('enabled', false);
  }

  public function hasParent(): bool
  {
    return $this->parent instanceof Layout;
  }

  public function parent(): ?Layout
  {
    return $this->parent;
  }

  public function uuid(): string
  {
    return $this->uuid;
  }

  public function __toString(): string
  {
    return $this->augmented()->render();
  }

  abstract public function render(): string;
}
