<?php

namespace Buildystrap\Traits;

use Illuminate\Support\Arr;

use function is_array;

trait Config
{
    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null === $key) {
            return $this->config;
        }

        return Arr::get($this->config, $key, $default);
    }

    /**
     * @param array|string $config
     * @param mixed|null $value
     * @return array
     */
    public function setConfig(array|string $config, mixed $value = null): array
    {
        if (is_array($config)) {
            return $this->config = $config;
        }

        if ($item = Arr::get($this->config, $config)) {
            if ($item !== $value) {
                Arr::forget($this->config, $config);
                $item = null;
            }
        }

        if ( ! $item) {
            $this->config = Arr::add($this->config, $config, $value);
        }

        return $this->config;
    }
}
