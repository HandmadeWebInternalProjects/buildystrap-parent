<?php

namespace Buildystrap\Strategies;

use Buildystrap\Interfaces\EmbedStrategy;

class VimeoStrategy implements EmbedStrategy
{
  private $id;

  public function __construct($url)
  {
    $this->id = $this->extractIdFromUrl($url);
  }

  public function getThumb()
  {
    // Extract just the numeric video ID (API v2 doesn't support privacy hash in URL)
    $video_id = strpos($this->id, '/') !== false ? explode('/', $this->id)[0] : $this->id;
    
    $vimeo_api = "http://vimeo.com/api/v2/video/{$video_id}.json";
    $response = wp_remote_get($vimeo_api);
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
      return '';
    }
    $response_body = wp_remote_retrieve_body($response);
    $json_data = json_decode($response_body);
    if (empty($json_data) || !isset($json_data[0]->thumbnail_large)) {
      return '';
    }
    return $json_data[0]->thumbnail_large;
  }

  public function embed($params = '')
  {
    return "<iframe src='{$this->embedUrl($params)}' width='100%' height='400' frameborder='0' allow='autoplay; fullscreen' allowfullscreen loading='lazy'></iframe>";
  }

  public function embedURL($params = '')
  {
    // Handle unlisted/private videos with privacy hash (e.g., "123456789/abc123def")
    if (strpos($this->id, '/') !== false) {
      list($video_id, $privacy_hash) = explode('/', $this->id, 2);
      $hash_param = "h={$privacy_hash}";
      $separator = empty($params) ? '' : '&';
      return "https://player.vimeo.com/video/{$video_id}?{$hash_param}{$separator}{$params}";
    }
    return "https://player.vimeo.com/video/{$this->id}?{$params}";
  }

  public function __toString()
  {
    return 'Vimeo';
  }

  public function extractIdFromUrl($url)
  {
    // Match both public videos (vimeo.com/123456789) and unlisted/private videos (vimeo.com/123456789/abc123def)
    $video_id_regex = '/vimeo\.com\/(\d+(?:\/[a-zA-Z0-9]+)?)/';
    $video_id = '';
    if (preg_match($video_id_regex, $url, $matches)) {
      $video_id = $matches[1];
    } else {
      // Fallback: extract the path after vimeo.com
      $path = parse_url($url, PHP_URL_PATH);
      $video_id = ltrim($path, '/');
    }
    return $video_id;
  }
}
