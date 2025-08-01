<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class SpinOff extends AbstractEntity
{
    protected int $objectId = 0;

    protected string $name = '';

    /**
     * @var string
     */
    protected mixed $details;

    /**
     * @var string
     */
    protected mixed $searchIndex;

    public function getObjectId(): int
    {
        return $this->objectId;
    }
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName($name): void
    {
        $this->name = $name;
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
}
