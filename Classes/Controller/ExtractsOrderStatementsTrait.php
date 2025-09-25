<?php

namespace Wtl\HioTypo3Connector\Controller;

use Wtl\HioTypo3Connector\Domain\Model\Publication;

trait ExtractsOrderStatementsTrait
{
    protected function getOrderingFromProperty(string $property): array
    {
        $orderings = [];
        $orderBy = $this->settings[$property] ?? '';
        if ($orderBy !== '') {
            [$propertyName, $order] = explode(':', $orderBy);
            if (in_array($propertyName, Publication::ORDERABLE_COLUMNS)) {
                $orderings = [$propertyName => $order];
            }
        }

        return $orderings;
    }
}