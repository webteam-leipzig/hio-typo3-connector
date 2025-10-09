<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithVisibility
{
    protected ?string $visibility;

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    public function setVisibility(?string $visibility): void
    {
        $this->visibility = $visibility;
    }
}
