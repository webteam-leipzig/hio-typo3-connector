<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Collection\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\PatentDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\PublicationDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class OrgUnitDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $title = '';

    protected array $doctoralPrograms = [];
    protected array $habilitations = [];
    protected array $patents = [];
    protected array $projects = [];
    protected array $publications = [];
    protected array $researchInfrastructures = [];
    protected array $spinOffs = [];

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPublications(): array
    {
        return $this->publications;
    }

    public function setPublications(array $publications): void
    {
        $this->publications = $publications;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }
    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
    }

    public function getPatents(): array
    {
        return $this->patents;
    }
    public function setPatents(array $patents): void
    {
        $this->patents = $patents;
    }

    public function getDoctoralPrograms(): array
    {
        return $this->doctoralPrograms;
    }
    public function setDoctoralPrograms(array $doctoralPrograms): void
    {
        $this->doctoralPrograms = $doctoralPrograms;
    }

    public function getHabilitations(): array
    {
        return $this->habilitations;
    }
    public function setHabilitations(array $habilitations): void
    {
        $this->habilitations = $habilitations;
    }

    public function getResearchInfrastructures(): array
    {
        return $this->researchInfrastructures;
    }
    public function setResearchInfrastructures(array $researchInfrastructures): void
    {
        $this->researchInfrastructures = $researchInfrastructures;
    }

    public function getSpinOffs(): array
    {
        return $this->spinOffs;
    }
    public function setSpinOffs(array $spinOffs): void
    {
        $this->spinOffs = $spinOffs;
    }

    static public function fromArray(array $data): OrgUnitDto
    {
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $dto->setTitle($data['name'] ?? '');

        $doctoralPrograms = [];
        foreach ($data['doctoralPrograms'] ?? [] as $doctoralProgram) {
            $doctoralPrograms[] = DoctoralProgramDto::fromArray($doctoralProgram);
        }
        $dto->setDoctoralPrograms($doctoralPrograms);

        $habilitations = [];
        foreach ($data['habilitations'] ?? [] as $habilitation) {
            $habilitations[] = HabilitationDto::fromArray($habilitation);
        }
        $dto->setHabilitations($habilitations);

        $patents = [];
        foreach ($data['patents'] ?? [] as $patent) {
            $patents[] = PatentDto::fromArray($patent);
        }
        $dto->setPatents($patents);

        $projects = [];
        foreach ($data['projects'] ?? [] as $project) {
            $projects[] = ProjectDto::fromArray($project);
        }
        $dto->setProjects($projects);

        $publications = [];
        foreach ($data['publications'] ?? [] as $publication) {
            $publications[] = PublicationDto::fromArray($publication);
        }
        $dto->setPublications($publications);

        $researchInfrastructures = [];
        foreach ($data['researchInfrastructures'] ?? [] as $researchInfrastructure) {
            $researchInfrastructures[] = \Wtl\HioTypo3Connector\Domain\Dto\Collection\ResearchInfrastructureDto::fromArray($researchInfrastructure);
        }
        $dto->setResearchInfrastructures($researchInfrastructures);

        $spinOffs = [];
        foreach ($data['spinOffs'] ?? [] as $spinOff) {
            $spinOffs[] = \Wtl\HioTypo3Connector\Domain\Dto\Collection\SpinOffDto::fromArray($spinOff);
        }
        $dto->setSpinOffs($spinOffs);

        return $dto;
    }
}
