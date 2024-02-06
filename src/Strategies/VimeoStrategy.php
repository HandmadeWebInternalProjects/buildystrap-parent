<?php

namespace Buildystrap\Strategies;

use Buildystrap\Interfaces\VideoStrategy;

class VimeoStrategy implements VideoStrategy
{
  private $id;

  public function __construct($url)
  {
    $this->id = $this->extractVideoIdFromVimeoUrl($url);
  }

  public function getThumb()
  {
    return "https://i.vimeocdn.com/video/{$this->id}_1280.jpg";
  }

  public function embed($params = '')
  {
    return "<iframe src='https://player.vimeo.com/video/{$this->id}?{$params}' width='100%' height='400' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>";
  }

  public function __toString()
  {
    return 'Vimeo';
  }

  private function extractVideoIdFromVimeoUrl($url)
  {
    $video_id_regex = '/vimeo.com\/([0-9]+)/';
    $video_id = '';
    if (preg_match($video_id_regex, $url, $video_id)) {
      $video_id = $video_id[1];
    } else {
      $video_id = substr(parse_url($url, PHP_URL_PATH), 1);
    }
    return $video_id;
  }
}
