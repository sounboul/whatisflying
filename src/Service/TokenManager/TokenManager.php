<?php

declare(strict_types=1);

namespace App\Service\TokenManager;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use App\Util\DateTime;
use Doctrine\ORM\EntityManagerInterface;

final class TokenManager implements TokenManagerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function deleteToken(Token $token): void
    {
        $this->entityManager->remove($token);
        $this->entityManager->flush();
    }

    public function generateToken(User $user, string $role, int $ttl = 3600): Token
    {
        if (!is_null($token = $this->getLatestValidToken($user, $role))) {
            return $token;
        }

        $expires = DateTime::getCurrentUtc();
        $expires->modify(sprintf('+%s second', $ttl));

        $token = new Token();
        $token
            ->setExpires($expires)
            ->setRole($role)
            ->setUser($user);

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $token;
    }

    public function getTokenById(string $id): ?Token
    {
        return $this->entityManager
            ->getRepository(Token::class)
            ->findOneBy(['id' => $id]);
    }

    public function isTokenValid(Token $token, string $expectedRole): bool
    {
        return $token->getRole() === $expectedRole &&
            $token->getExpires() > DateTime::getCurrentUtc();
    }

    private function getLatestValidToken(User $user, string $role): ?Token
    {
        /** @var TokenRepository $repository */
        $repository = $this->entityManager->getRepository(Token::class);

        return $repository->findLatestValidTokenByUserAndRole($user, $role);
    }
}
