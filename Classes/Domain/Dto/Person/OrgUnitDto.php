<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

class OrgUnitDto
{
    protected ?array $affiliations = [];
    protected int $id;
    protected string $name = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAffiliations(): ?array
    {
        return $this->affiliations;
    }

    public function setAffiliations(?array $affiliations): void
    {
        $this->affiliations = $affiliations;
    }

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }

        $dto = new self();
        $dto->setId($data['id']);
        $dto->setName($data['name'] ?? '');
        $dto->setAffiliations($data['affiliations'] ?? []);

        return $dto;
    }
}
