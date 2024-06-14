<?php

namespace Buildystrap\Interfaces;

interface EmbedStrategy
{
  public function __construct($url);
  public function __toString();
  public function embed($params = '');
  public function embedUrl($params = '');
  public function getThumb();
  public function extractIdFromUrl($url);
}
