<?php

namespace Buildystrap\Traits;

use Buildystrap\Arr;

trait InlineAttributes
{
    /**
     * @var array
     */
    protected $inline_attributes = [];

    /**
     * @return array
     */
    public function getInlineAttributes(): array
    {
        return $this->inline_attributes;
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function setInlineAttributes(array $attributes): array
    {
        return $this->inline_attributes = $attributes;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getInlineAttribute(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->inline_attributes, $key, $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return array
     */
    public function setInlineAttribute(string $key, mixed $value): array
    {
        if ($item = Arr::get($this->inline_attributes, $key)) {
            if ($item !== $value) {
                Arr::forget($this->inline_attributes, $key);
                $item = null;
            }
        }

        if ( ! $item) {
            $this->inline_attributes = Arr::add($this->inline_attributes, $key, $value);
        }

        return $this->inline_attributes;
    }
}
