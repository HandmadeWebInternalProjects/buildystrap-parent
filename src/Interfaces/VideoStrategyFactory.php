<?php

namespace Buildystrap\Interfaces;

use Buildystrap\Interfaces\VideoStrategy;

interface VideoStrategyFactory
{
  public function createStrategy(string $url): VideoStrategy;
}
