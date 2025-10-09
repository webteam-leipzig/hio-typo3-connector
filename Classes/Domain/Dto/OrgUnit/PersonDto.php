<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

class PersonDto
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
        $personDto = new self();
        $personDto->setId($data['id']);
        $personDto->setName($data['name'] ?? '');
        $personDto->setAffiliations($data['affiliations'] ?? []);
        return $personDto;
    }
}
