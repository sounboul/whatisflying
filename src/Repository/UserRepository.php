<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    public function __construct(
        private LoggerInterface $logger,
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, User::class);
    }

    /**
     * @param UserInterface $user
     * @param string        $newHashedPassword
     */
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $entityManager = $this->getEntityManager();

        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (ORMException $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    /**
     * @param string $identifier
     *
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function loadUserByIdentifier(string $identifier): ?User
    {
        return $this->loadUserByUsername($identifier);
    }

    /**
     * @param string $username
     *
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function loadUserByUsername(string $username): ?User
    {
        $builder = $this
            ->getEntityManager()
            ->createQueryBuilder();

        $query = $builder
            ->select('user')
            ->from(User::class, 'user')
            ->where($builder->expr()->eq('user.email', ':username'))
            ->orWhere($builder->expr()->eq('user.username', ':username'))
            ->setParameter('username', $username)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
