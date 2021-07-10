<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Token;
use App\Entity\User;
use App\Util\DateTime;
use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<Token>
 */
class TokenRepository extends EntityRepository
{
    public function findLatestValidTokenByUserAndRole(User $user, string $role): ?Token
    {
        $builder = $this->createQueryBuilder('token');
        $query = $builder
            ->where($builder->expr()->eq('token.user', ':user'))
            ->andWhere($builder->expr()->eq('token.role', ':role'))
            ->andWhere($builder->expr()->gt('token.expires', ':expires'))
            ->orderBy('token.expires', 'DESC')
            ->setMaxResults(1)
            ->setParameter(':expires', DateTime::getCurrentUtc())
            ->setParameter(':role', $role)
            ->setParameter(':user', $user)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
