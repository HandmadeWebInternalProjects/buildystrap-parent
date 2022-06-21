<?php

namespace Buildystrap;

use Illuminate\Support\Collection;

class ViteManifest
{
    protected string $file;
    protected string $path;
    protected string $url;

    protected Collection $items;

    public function __construct(string $file, string $path, string $url)
    {
        $this->file = $file;
        $this->path = $path;
        $this->url = $url;

        $this->items = collect([]);

        if (file_exists("$this->path/$this->file") && $items = json_decode(file_get_contents("$this->path/$this->file"))) {
            foreach ($items as $item) {
                $this->items->put($item->src, $item);
            }
        }
    }

    public function getScriptFor(string $src): mixed
    {
        return $this->items->get($src)->file ?? null;
    }

    public function getStylesFor(string $src): array
    {
        return $this->items->get($src)->css ?? [];
    }

    public function getUrlFor(string $file): string
    {
        return "$this->url/$file";
    }

    public function has(string $key): bool
    {
        return $this->items->has($key);
    }
}
