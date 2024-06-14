<?php

namespace Buildystrap\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Roots\Acorn\View\Component as AcornBaseComponent;

abstract class BaseComponent extends AcornBaseComponent
{
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return View|Closure|string
   */
  public function render($view = null, $data = [], $mergeData = [])
  {
    $views = collect([
      $view,
      "components.{$this->componentName}"
    ])->filter()->map(fn ($el) => trim($el))->first();

    return $this->view($views, $data, $mergeData);
  }
}
