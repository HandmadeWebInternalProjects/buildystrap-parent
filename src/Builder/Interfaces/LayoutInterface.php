<?php

namespace Buildystrap\Builder\Interfaces;

interface LayoutInterface
{
    public function render(): string;

    public function __toString(): string;
}
