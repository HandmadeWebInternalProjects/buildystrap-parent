<?php

namespace Buildystrap\Builder\Fields;

use Buildystrap\Builder\Extends\Field;

use function collect;
use function wp_get_attachment_image;

class ImageField extends Field
{
    protected static function blueprint(): array
    {
        return [
          'config' => [],
        ];
    }

    public function __toString(): string
    {
        $image = isset($this->value()['image']) ? $this->value()['image'] : null;
        if (! $image) {
            return false;
        }
        return collect($image)
          ->map(fn ($item) => wp_get_attachment_image_url($item['id'], 'full'))
          ->first();
    }

    public function toHtml(): string
    {
        global $bodhi_svgs_options;
        $image = optional(collect($this->value()['image'] ?? []))->pluck('id')->first();
        $inline_svg = optional($bodhi_svgs_options)['force_inline_svg'] === 'on';
        $width = optional($this->value())['width'] ? "width: {$this->value()['width']};" : '';
        $max_width = optional($this->value())['max_width'] ? "max-width: {$this->value()['max_width']};" : '';
        $height = optional($this->value())['height'] ? "height: {$this->value()['height']};" : '';
        $max_height = optional($this->value())['max_height'] ? "max-height: {$this->value()['max_height']};" : '';
        $aspect_ratio = optional($this->value())['aspect_ratio'] ? "aspect-ratio: {$this->value()['aspect_ratio']};" : '';
        $classes = collect([
          optional($this->value())['object_fit'] ? "object-{$this->value()['object_fit']}" : 'full',
          optional($this->value())['object_position'] ? "object-position-{$this->value()['object_position']}" : null,
        ])->filter()->implode(' ');

        if (! $image) {
            return false;
        }

        $html = '';
        if ($inline_svg && wp_check_filetype(wp_get_attachment_url($image))['ext'] === 'svg') {
            $html .= "<div class='svg-container' style='" . trim("$width $max_width $height $max_height $aspect_ratio") . "'>";
        }
        $html .= wp_get_attachment_image($image, 'full', false, [
          'class' => $classes,
          'alt' => $this->value()['alt'] ?? '',
          'style' => trim("$width $max_width $height $max_height $aspect_ratio"),
        ]);
        if ($inline_svg && wp_check_filetype(wp_get_attachment_url($image))['ext'] === 'svg') {
            $html .= '</div>';
        }
        return $html;
    }
}
