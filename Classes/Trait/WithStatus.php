<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithStatus
{
    protected ?string $status;

    public function getStatus(): string|null
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
}
