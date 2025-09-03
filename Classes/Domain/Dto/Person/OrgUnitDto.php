<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

class OrgUnitDto
{
    protected int $id;
    protected string $name = '';
    protected string $role = '';
    protected ?\DateTime $validFrom = null;
    protected ?\DateTime $validTo = null;
    protected string $visibilityValueId = '';

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

    public function getRole(): string
    {
        return $this->role;
    }
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getValidFrom(): ?\DateTime
    {
        return $this->validFrom;
    }
    public function setValidFrom(?\DateTime $validFrom): void
    {
        $this->validFrom = $validFrom;
    }

    public function getValidTo(): ?\DateTime
    {
        return $this->validTo;
    }
    public function setValidTo(?\DateTime $validTo): void
    {
        $this->validTo = $validTo;
    }

    public function getVisibilityValueId(): string
    {
        return $this->visibilityValueId;
    }
    public function setVisibilityValueId(string $visibilityValueId): void
    {
        $this->visibilityValueId = $visibilityValueId;
    }

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }
        $dto = new self();
        $dto->setId($data['id']);
        $dto->setName($data['name'] ?? '');
        $dto->setRole($data['role'] ?? '');
        $dto->setValidFrom(isset($data['validFrom']) ? new \DateTime($data['validFrom']) : null);
        $dto->setValidTo(isset($data['validTo']) ? new \DateTime($data['validTo']) : null);
        $dto->setVisibilityValueId($data['visibilityValueId'] ?? '');

        return $dto;
    }
}
