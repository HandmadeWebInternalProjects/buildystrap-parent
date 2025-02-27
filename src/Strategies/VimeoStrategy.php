<?php

namespace Buildystrap\Strategies;

use Buildystrap\Interfaces\EmbedStrategy;

class VimeoStrategy implements EmbedStrategy
{
  private $id;
  private $url;

  public function __construct($url)
  {
    $this->url = $url;
    $this->id = $this->extractIdFromUrl($url);
  }

  public function getThumb()
  {
    $vimeo_api = "http://vimeo.com/api/v2/video/{$this->id}.json";
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
    $oEmbedData = $this->getOembedData($this->url, $params);

    if (empty($oEmbedData)) {
      return '';
    }

    $html = $oEmbedData->html;

    return $html;
  }

  public function embedURL($params = '')
  {
    return "https://player.vimeo.com/video/{$this->id}?{$params}";
  }

  public function __toString()
  {
    return 'Vimeo';
  }

  public function extractIdFromUrl($url)
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

  public function getOembedData($url, $params)
  {
    $oembed_api = "https://vimeo.com/api/oembed.json?url={$url}&{$params}";

    $response = wp_remote_get($oembed_api);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
      return '';
    }

    $response_body = wp_remote_retrieve_body($response);

    return json_decode($response_body);
  }
}
