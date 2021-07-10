<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Token;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Token
 */
final class TokenTest extends TestCase
{
    /**
     * @testdox Sets/gets the token expiration date and time.
     */
    public function testExpires(): void
    {
        $expires = $this
            ->getMockBuilder(\DateTime::class)
            ->getMock();

        $token = new Token();
        $token->setExpires($expires);

        self::assertEquals($expires, $token->getExpires());
    }

    /**
     * @testdox Sets/gets the token role.
     */
    public function testRole(): void
    {
        $token = new Token();
        $token->setRole('reset_password');

        self::assertEquals('reset_password', $token->getRole());
    }

    /**
     * @testdox Sets/gets the user to which the token belongs.
     */
    public function testUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $token = new Token();
        $token->setUser($user);

        self::assertEquals($user, $token->getUser());
    }
}
