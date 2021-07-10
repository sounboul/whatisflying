<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Airport;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @extends EntityRepository<Airport>
 */
class AirportRepository extends EntityRepository
{
    /**
     * @return Airport[]
     */
    public function findAllIcaoCode(): array
    {
        $builder = $this->createQueryBuilder('airport');
        $query = $builder
            ->select('PARTIAL airport.{id,icaoCode}')
            ->orderBy('airport.icaoCode', 'ASC')
            ->getQuery();

        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $query->getResult();
    }
}
