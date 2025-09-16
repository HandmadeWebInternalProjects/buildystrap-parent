<?php

namespace Buildystrap\Strategies;

use Buildystrap\Interfaces\EmbedStrategy;

class YoutubeStrategy implements EmbedStrategy
{
    private $id;

    public function __construct($url)
    {
        $this->id = $this->extractIdFromUrl($url);
    }

    public function embed($params = '')
    {
        return "<iframe src='{$this->embedUrl($params)}' width='100%' height='400' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>";
    }

    public function embedUrl($params = '')
    {
        return "https://www.youtube.com/embed/{$this->id}?{$params}";
    }

    public function getThumb()
    {
        $thumbnailUrls = [
          "https://img.youtube.com/vi/{$this->id}/maxresdefault.jpg",
          "https://img.youtube.com/vi/{$this->id}/hqdefault.jpg",
          "https://img.youtube.com/vi/{$this->id}/sddefault.jpg",
          "https://img.youtube.com/vi/{$this->id}/mqdefault.jpg",
          "https://img.youtube.com/vi/{$this->id}/0.jpg"
        ];

        foreach ($thumbnailUrls as $url) {
            // Use get_headers to check if the image exists
            $headers = @get_headers($url);
            if ($headers && strpos($headers[0], '200') !== false) {
                return $url;
            }
        }
        return false; // No thumbnail available
    }

    public function __toString()
    {
        return 'Youtube';
    }

    public function extractIdFromUrl($url)
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
