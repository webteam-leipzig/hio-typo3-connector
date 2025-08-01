<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Persistence\Repository;

class BaseRepository extends Repository
{
    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    public function findBySearchTerm(string $searchTerm)
    {
        $searchTerm = trim($searchTerm);
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr(
                $query->like('searchIndex', '%' . strtolower($searchTerm) . '%'),
            )
        );

        return $query->execute();
    }
}
