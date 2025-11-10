<?php

declare(strict_types=1);

namespace Classes\Trait;

trait WithUniqueName
{
    protected string $uniqueName = '';

    public function getUniqueName(): string
    {
        return $this->uniqueName;
    }

    public function setUniqueName(string $uniqueName): void
    {
        $this->uniqueName = $uniqueName;
    }
}
