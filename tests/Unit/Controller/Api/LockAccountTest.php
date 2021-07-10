<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\Api;

use App\Controller\Api\User\LockAccount;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Controller\Api\User\LockAccount
 */
final class LockAccountTest extends TestCase
{
    /**
     * @testdox Method __invoke() returns the user.
     */
    public function testInvokeReturnUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $lockAccount = new LockAccount();
        
        self::assertEquals($user, $lockAccount->__invoke($user));
    }
}
