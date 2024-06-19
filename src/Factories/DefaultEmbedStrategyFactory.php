<?php

namespace Buildystrap\Factories;

use Buildystrap\Interfaces\EmbedStrategy;
use Buildystrap\Interfaces\EmbedStrategyFactory;
use Buildystrap\Strategies\YoutubeStrategy;
use Buildystrap\Strategies\VimeoStrategy;

class DefaultEmbedStrategyFactory implements EmbedStrategyFactory
{
  private $strategies;

  public function __construct()
  {
    $this->strategies = [
      'youtube.com' => YoutubeStrategy::class,
      'youtu.be' => YoutubeStrategy::class,
      'vimeo.com' => VimeoStrategy::class,
    ];

    $this->strategies = apply_filters('modify_embed_strategies', $this->strategies);
  }

  public function createStrategy(string $url): EmbedStrategy
  {
    foreach ($this->strategies as $key => $strategy) {
      if (strpos($url, $key) !== false) {
        /** @var EmbedStrategy $instance */
        $instance = new $strategy($url);
        return $instance;
      }
    }

    throw new \InvalidArgumentException('Unsupported embed type');
  }
}