<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\PatentRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPatentToHioPersonsEvent;

class AttachHioPatentToHioPersonsListener
{
    public function __construct(
        protected readonly PatentRepository $patentRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }
    public function __invoke(AttachHioPatentToHioPersonsEvent $event): void
    {
        $patent = $this->patentRepository->findByObjectId($event->getHioPatentObjectId());
        if ($patent === null) {
            return;
        }

        foreach ($event->getHioPersonObjectIds() as $hioPersonObjectId) {
            $person = $this->personRepository->findByObjectId($hioPersonObjectId);
            if ($person === null) {
                continue;
            }
            $person->addPatent($patent);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
