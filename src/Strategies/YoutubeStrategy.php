<?php

namespace Buildystrap\Strategies;

use Buildystrap\Interfaces\VideoStrategy;

class YoutubeStrategy implements VideoStrategy
{
  private $id;

  public function __construct($url)
  {
    $this->id = $this->extractVideoIdFromYoutubeUrl($url);
  }

  public function embed($params = '')
  {
    return "<iframe src='https://www.youtube.com/embed/{$this->id}?{$params}' width='100%' height='400' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>";
  }


  public function getThumb()
  {
    return "https://img.youtube.com/vi/{$this->id}/maxresdefault.jpg";
  }

  public function __toString()
  {
    return 'Youtube';
  }

  private function extractVideoIdFromYoutubeUrl($url)
  {
    $video_id_regex = '/[\\?\\&]v=([^\\?\\&]+)/';
    $video_id = '';
    if (preg_match($video_id_regex, $url, $video_id)) {
      $video_id = $video_id[1];
    } else {
      $video_id = substr(parse_url($url, PHP_URL_PATH), 1);
    }
    return $video_id;
  }
}
