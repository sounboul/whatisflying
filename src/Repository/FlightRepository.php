<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Flight;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @extends EntityRepository<Flight>
 */
class FlightRepository extends EntityRepository
{
    /**
     * @return Flight[]
     */
    public function findAllFlightNumber(): array
    {
        $builder = $this->createQueryBuilder('flight');
        $query = $builder
            ->select('PARTIAL flight.{id,flightNumber}')
            ->orderBy('flight.flightNumber', 'ASC')
            ->getQuery();

        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $query->getResult();
    }
}
