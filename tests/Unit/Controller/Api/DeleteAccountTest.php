<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\Api;

use App\Controller\Api\User\DeleteAccount;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Controller\Api\User\DeleteAccount
 */
final class DeleteAccountTest extends TestCase
{
    /**
     * @testdox Method __invoke() returns the user.
     */
    public function testInvokeReturnUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $deleteAccount = new DeleteAccount();
        
        self::assertEquals($user, $deleteAccount->__invoke($user));
    }
}
