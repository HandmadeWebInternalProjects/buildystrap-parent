<?php

namespace Buildystrap;

use Buildystrap\Factories\DefaultVideoStrategyFactory;

class VideoContext
{
  private $factory;
  private $strategy;

  public function __construct(DefaultVideoStrategyFactory $factory, string $url)
  {
    $this->factory = $factory;

    if ($url) {
      $this->strategy = $this->factory->createStrategy($url);
    }
  }

  public function embed($params = '')
  {
    return $this->strategy->embed($params);
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
