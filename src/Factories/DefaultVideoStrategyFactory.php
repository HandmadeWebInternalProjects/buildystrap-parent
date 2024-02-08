<?php

namespace Buildystrap\Factories;

use Buildystrap\Interfaces\VideoStrategy;
use Buildystrap\Interfaces\VideoStrategyFactory;
use Buildystrap\Strategies\YoutubeStrategy;
use Buildystrap\Strategies\VimeoStrategy;

class DefaultVideoStrategyFactory implements VideoStrategyFactory
{
  public function createStrategy(string $url): VideoStrategy
  {
    if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
      return new YoutubeStrategy($url);
    } elseif (strpos($url, 'vimeo.com') !== false) {
      return new VimeoStrategy($url);
    } else {
      throw new \InvalidArgumentException('Unsupported video platform');
    }
  }
}
