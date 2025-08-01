<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use Psr\EventDispatcher\EventDispatcherInterface;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Event\ReceiveHioOrgUnitEvent;

class ReceiveHioOrgUnitListener
{
    public function __construct(
        protected readonly OrgUnitRepository $repository,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(ReceiveHioOrgUnitEvent $event): void
    {
        $this->repository->save($event->getHioOrgUnit(), $event->getStoragePid());
    }
}
