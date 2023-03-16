<?php

namespace Buildystrap\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

use function defined;

use const WP_DEBUG;

trait CollectionClass
{
    public function collectionClass($items = []): Collection|LazyCollection
    {
        $collectionClass = match (true) {
            (defined('WP_DEBUG') && WP_DEBUG) => Collection::class,
            default => LazyCollection::class
        };

        return new $collectionClass($items);
    }
}
