<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AircraftType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @extends EntityRepository<AircraftType>
 */
class AircraftTypeRepository extends EntityRepository
{
    /**
     * @return AircraftType[]
     */
    public function findAllIcaoCode(): array
    {
        $builder = $this->createQueryBuilder('aircraft_type');
        $query = $builder
            ->select('PARTIAL aircraft_type.{id,icaoCode}')
            ->orderBy('aircraft_type.icaoCode', 'ASC')
            ->getQuery();

        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $query->getResult();
    }
}
