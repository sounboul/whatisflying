<?php

declare(strict_types=1);

namespace Tests\Unit\Security;

use App\Entity\User;
use App\Security\UserChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\LockedException;

/**
 * @covers \App\Security\UserChecker
 */
final class UserCheckerTest extends TestCase
{
    /**
     * @testdox Method checkPostAuth() throws on disabled account.
     */
    public function testThrowOnDisabledAccount(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->onlyMethods(['isEnabled'])
            ->getMock();

        $user
            ->method('isEnabled')
            ->will(self::returnValue(false));

        $userChecker = new UserChecker();

        self::expectException(DisabledException::class);
        
        $userChecker->checkPostAuth($user);
    }

    /**
     * @testdox Method checkPostAuth() throws on locked account.
     */
    public function testThrowOnLockedAccount(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->onlyMethods(['isLocked'])
            ->getMock();

        $user
            ->method('isLocked')
            ->will(self::returnValue(true));

        $userChecker = new UserChecker();

        self::expectException(LockedException::class);

        $userChecker->checkPostAuth($user);
    }
}
