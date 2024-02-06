<?php

namespace Buildystrap\Interfaces;

interface VideoStrategy
{
  public function __construct($url);
  public function __toString();
  public function embed($params = '');
  public function getThumb();
}
