<?php

namespace Buildystrap\Traits;

trait Augment
{
    /**
     * @var bool
     */
    protected bool $augmented = false;

    /**
     * Augment once
     * @return void
     */
    public function augmentOnce(): void
    {
        if ($this->isNotAugmented()) {
            $this->augment();
            $this->setAugmented();
        }
    }

    /**
     * Check if $this has not been augmented.
     * @return bool
     */
    public function isNotAugmented(): bool
    {
        return ! $this->isAugmented();
    }

    /**
     * Check if $this has been augmented.
     * @return bool
     */
    public function isAugmented(): bool
    {
        return $this->augmented;
    }

    /**
     * Set $this augmented status.
     * @param bool $augmented
     */
    public function setAugmented(bool $augmented = true): void
    {
        $this->augmented = $augmented;
    }

    /**
     * Augment $this.
     * @return void
     */
    public function augment(): void
    {
    }
}
