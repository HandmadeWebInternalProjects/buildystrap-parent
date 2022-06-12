<?php

namespace Buildystrap\Traits;

use Illuminate\Support\Arr;

trait hasConfig
{
    protected array $config = [];

    public function addToConfig(string $key, $value)
    {
        if ($item = Arr::get($this->config, $key)) {
            if ($item !== $value) {
                Arr::forget($this->config, $key);
                $item = null;
            }
        }

        if (!$item) {
            $this->config = Arr::add($this->config, $key, $value);
        }

        return $this->config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getFromConfig(string $key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }
}
