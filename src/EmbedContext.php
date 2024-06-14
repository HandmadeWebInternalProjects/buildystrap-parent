<?php

namespace Buildystrap;

use Buildystrap\Interfaces\EmbedStrategyFactory;
use Buildystrap\Factories\DefaultEmbedStrategyFactory;

class EmbedContext
{
  private $factory;
  private $strategy;

  public function __construct(string $url, EmbedStrategyFactory $factory = null)
  {
    $this->factory = $factory ?? new DefaultEmbedStrategyFactory();

    if ($url) {
      $this->strategy = $this->factory->createStrategy($url);
    }
  }

  public function embed($params = '')
  {
    return $this->strategy->embed($params);
  }

  public function embedUrl($params = '')
  {
    return $this->strategy->embedUrl($params);
  }

  public function getVideoType()
  {
    return $this->strategy->__toString() ?? null;
  }

  public function setStrategy($url)
  {
    $this->strategy = $this->factory->createStrategy($url);
  }

  public function getThumb()
  {
    return $this->strategy->getThumb();
  }
}
