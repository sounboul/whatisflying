<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Aircraft;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @extends EntityRepository<Aircraft>
 */
class AircraftRepository extends EntityRepository
{
    /**
     * @return Aircraft[]
     */
    public function findAllIcao24bitAddress(): array
    {
        $builder = $this->createQueryBuilder('aircraft');
        $query = $builder
            ->select('PARTIAL aircraft.{id,icao24bitAddress}')
            ->orderBy('aircraft.icao24bitAddress', 'ASC')
            ->getQuery();

        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $query->getResult();
    }

    /**
     * @return Aircraft[]
     */
    public function findAllCacheableProperties(): array
    {
        $builder = $this->createQueryBuilder('aircraft');
        $query = $builder
            ->select('PARTIAL aircraft.{id,description,icao24bitAddress}, PARTIAL aircraft_type.{id,icaoCode}')
            ->leftJoin('aircraft.aircraftType', 'aircraft_type')
            ->orderBy('aircraft.icao24bitAddress', 'ASC')
            ->getQuery();

        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $query->getResult();
    }
}
