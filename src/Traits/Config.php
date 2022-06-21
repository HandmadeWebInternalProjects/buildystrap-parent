<?php

namespace Buildystrap\Traits;

use Illuminate\Support\Arr;

trait Config
{
    protected array $config = [];

    public function addToConfig(string $key, $value): array
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

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getFromConfig(string $key, $default = null): mixed
    {
        return Arr::get($this->config, $key, $default);
    }
}
