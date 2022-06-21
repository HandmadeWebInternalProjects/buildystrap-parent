<?php

namespace Buildystrap\Traits;

use Illuminate\Support\Arr;

trait Attributes
{
    /**
     * @var array
     */
    protected array $attributes = [];

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param  array  $attributes
     * @return array
     */
    public function setAttributes(array $attributes): array
    {
        return $this->attributes = $attributes;
    }

    /**
     * @param  string  $key
     * @param  mixed|null  $default
     * @return mixed
     */
    public function getAttribute(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->attributes, $key, $default);
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @return array
     */
    public function setAttribute(string $key, mixed $value): array
    {
        if ($item = Arr::get($this->attributes, $key)) {
            if ($item !== $value) {
                Arr::forget($this->attributes, $key);
                $item = null;
            }
        }

        if (!$item) {
            $this->attributes = Arr::add($this->attributes, $key, $value);
        }

        return $this->attributes;
    }
}
