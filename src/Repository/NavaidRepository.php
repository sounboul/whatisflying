<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Navaid;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @extends EntityRepository<Navaid>
 */
class NavaidRepository extends EntityRepository
{
    /**
     * @return Navaid[]
     */
    public function findAllSlug(): array
    {
        $builder = $this->createQueryBuilder('navaid');
        $query = $builder
            ->select('PARTIAL navaid.{id,slug}')
            ->orderBy('navaid.slug', 'ASC')
            ->getQuery();

        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $query->getResult();
    }
}
