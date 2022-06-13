<?php

namespace Buildystrap\Builder\Interfaces;

interface ModuleInterface
{
    public function render(): string;

    public function __toString(): string;
}
