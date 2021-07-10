<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\Api;

use App\Controller\Api\User\RequestPasswordReset;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Controller\Api\User\RequestPasswordReset
 */
final class RequestPasswordResetTest extends TestCase
{
    /**
     * @testdox Method __invoke() returns the user.
     */
    public function testInvokeReturnUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $requestPasswordReset = new RequestPasswordReset();
        
        self::assertEquals($user, $requestPasswordReset->__invoke($user));
    }
}
