<?php

namespace Buildystrap\Interfaces;

use Buildystrap\Interfaces\EmbedStrategy;

interface EmbedStrategyFactory
{
  public function createStrategy(string $url): EmbedStrategy;
}
