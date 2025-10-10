<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\NominationDto;
use Wtl\HioTypo3Connector\Domain\Model\Nomination;

class NominationRepository extends BaseRepository
{
    public function save(NominationDto $dto, $storagePageId): void
    {
        $model = $this->findByObjectId($dto->getObjectId());

        if ($model === null) {
            $model = new Nomination();
            $model->setObjectId($dto->getObjectId());
            $model->setStatus($dto->getStatus());
            $model->setTitle($dto->getTitle());
            $model->setType($dto->getType());
            $model->setVisibility($dto->getVisibility());
            $model->setDetails($dto->getDetails());
            $model->setSearchIndex($dto->getSearchIndex());
            $model->setPid($storagePageId);

            $this->add($model);
        } else {
            $model->setObjectId($dto->getObjectId());
            $model->setStatus($dto->getStatus());
            $model->setTitle($dto->getTitle());
            $model->setType($dto->getType());
            $model->setVisibility($dto->getVisibility());
            $model->setDetails($dto->getDetails());
            $model->setSearchIndex($dto->getSearchIndex());
            $this->update($model);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?Nomination
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
