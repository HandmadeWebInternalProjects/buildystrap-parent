<?php

namespace Buildystrap\View\Components;

class LoopComponent extends BaseComponent
{
    // Optional example (render exists on parent and doesn't need to be here)
    public function render($view = null, $data = [], $mergeData = [])
    {
        return parent::render($view, $data, $mergeData); // View will default to the component name/key as configured in config/view.php
    }
}
