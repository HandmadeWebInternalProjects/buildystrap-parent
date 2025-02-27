<?php

namespace Buildystrap\Traits;

trait Visibility
{
    /**
     * @var array
     */
    protected $visibility_classes = [];
    protected $all = 3;

    /**
     * @return array
     */
    public function hideOnAll(): bool
    {
        return count($this->visibility_classes) >= $this->all;
    }
}
