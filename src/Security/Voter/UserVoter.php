<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class UserVoter extends Voter
{
    public const LOCK_ACCOUNT = 'LOCK_ACCOUNT';
    public const UNLOCK_ACCOUNT = 'UNLOCK_ACCOUNT';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof User && in_array($attribute, [self::LOCK_ACCOUNT, self::UNLOCK_ACCOUNT], true);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if ($subject === $token->getUser() || !$this->security->isGranted('ROLE_ADMIN', $token->getUser())) {
            return false;
        }

        return match ($attribute) {
            self::LOCK_ACCOUNT => !$subject->isLocked(),
            self::UNLOCK_ACCOUNT => $subject->isLocked(),
            default => throw new \LogicException(
                sprintf('Unsupported attribute "%s" in voter class %s.', $attribute, self::class)
            )
        };
    }
}
