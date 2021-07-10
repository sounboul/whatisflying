<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\Api;

use App\Controller\Api\User\UpdatePassword;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Controller\Api\User\UpdatePassword
 */
final class UpdatePasswordTest extends TestCase
{
    /**
     * @testdox Method __invoke() returns the user.
     */
    public function testInvokeReturnUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $updatePassword = new UpdatePassword();
        
        self::assertEquals($user, $updatePassword->__invoke($user));
    }
}
