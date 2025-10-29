<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Nomination;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\EndowedDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\TypeDto;
use Wtl\HioTypo3Connector\Domain\Dto\Nomination\Prize\AwardingOrganizationDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;

class PrizeDto
{
    use WithDescription;
    use WithId;
    use WithStatus;
    use WithTitle;

    protected ?array $awardingOrganizations = null;
    protected ?string $category;
    protected ?EndowedDto $endowed;

    protected ?TypeDto $type;

    public function getAwardingOrganizations(): ?array
    {
        return $this->awardingOrganizations;
    }
    public function setAwardingOrganizations(?array $awardingOrganizations): void
    {
        $this->awardingOrganizations = $awardingOrganizations;
    }
    public function getCategory(): ?string
    {
        return $this->category;
    }
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }
    public function getEndowed(): ?EndowedDto
    {
        return $this->endowed;
    }
    public function setEndowed(?EndowedDto $endowed): void
    {
        $this->endowed = $endowed;
    }

    public function getType(): ?TypeDto
    {
        return $this->type;
    }
    public function setType(?TypeDto $type): void
    {
        $this->type = $type;
    }

    static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->setAwardingOrganizations(array_map(fn($item) => AwardingOrganizationDto::fromArray($item), $data['awardingOrganizations'] ?? []));
        $instance->setCategory($data['category'] ?? null);
        $instance->setDescription($data['description'] ?? null);
        $instance->setEndowed(EndowedDto::fromArray($data['endowed']) ?? null);
        $instance->setId($data['id'] ?? null);
        $instance->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $instance->setTitle($data['title'] ?? null);
        $instance->setType(TypeDto::fromArray($data['type']) ?? null);
        return $instance;
    }
}
