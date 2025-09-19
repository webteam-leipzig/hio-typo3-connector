<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Wtl\HioTypo3Connector\Trait\WithEndDate;
use Wtl\HioTypo3Connector\Trait\WithStartDate;

class Project extends AbstractEntity
{
    use WithEndDate;
    use WithStartDate;

    protected int $objectId = 0;

    protected string $status = '';

    protected string $title = '';

    protected string $type = '';

    /**
     * @var string
     */
    protected mixed $details;

     /**
     * @var string
     */
    protected mixed $searchIndex;

    /**
     * @var string
     */
    protected mixed $schemaOrg;

    public function getObjectId(): int
    {
        return $this->objectId;
    }
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getDetails(): mixed
    {
        return json_decode($this->details, true);
    }
    public function setDetails($details): void
    {
        $this->details = json_encode($details);
    }

    /**
     * Get the value of searchIndex
     *
     * @return  string
     */
    public function getSearchIndex()
    {
        return $this->searchIndex;
    }

    /**
     * Set the value of searchIndex
     *
     * @param  string  $searchIndex
     *
     * @return  self
     */
    public function setSearchIndex(string $searchIndex)
    {
        $this->searchIndex = $searchIndex;

        return $this;
    }

    public function getSchemaOrg()
    {
        return json_decode($this->schemaOrg, true);
    }

    public function setSchemaOrg(array $schemaOrg)
    {
        $this->schemaOrg = json_encode($schemaOrg);
        return $this;
    }

    public function updateSchemaOrg()
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ResearchProject',
            'name' => $this->getTitle(),
            'description' => $this->getDetails()['abstract'] ?? '',
        ];

        if (!empty($this->getDetails()['keywords'])) {
            $schema['keywords'] = implode(', ', $this->getDetails()['keywords']);
        }
        return $this->setSchemaOrg($schema);
    }
}
