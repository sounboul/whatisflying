<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Airline;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @extends EntityRepository<Airline>
 */
class AirlineRepository extends EntityRepository
{
    /**
     * @return Airline[]
     */
    public function findAllIcaoCode(): array
    {
        $builder = $this->createQueryBuilder('airline');
        $query = $builder
            ->select('PARTIAL airline.{id,icaoCode}')
            ->orderBy('airline.icaoCode', 'ASC')
            ->getQuery();

        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $query->getResult();
    }
}
