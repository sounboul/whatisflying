<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\Api;

use App\Controller\Api\User\ActivateAccount;
use App\Entity\Token;
use App\Entity\User;
use App\Service\TokenManager\TokenManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Api\User\ActivateAccount
 */
final class ActivateAccountTest extends TestCase
{
    private MockObject|TokenManagerInterface $tokenManager;

    public function setUp(): void
    {
        $this->tokenManager = $this
            ->getMockBuilder(TokenManagerInterface::class)
            ->onlyMethods(['getTokenById', 'isTokenValid'])
            ->getMockForAbstractClass();
    }

    /**
     * @testdox Method __invoke() returns the user.
     */
    public function testInvokeReturnUser(): void
    {
        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $this->tokenManager
            ->method('getTokenById')
            ->with('72e68657-1f07-4051-aacc-bf9f73916824')
            ->will(self::returnValue($token));

        $this->tokenManager
            ->method('isTokenValid')
            ->with($token)
            ->will(self::returnValue(true));

        $user = $this
            ->getMockBuilder(User::class)
            ->onlyMethods(['getToken'])
            ->getMock();

        $user
            ->method('getToken')
            ->will(self::returnValue('72e68657-1f07-4051-aacc-bf9f73916824'));

        $activateAccount = new ActivateAccount($this->tokenManager);

        self::assertEquals($user, $activateAccount->__invoke($user));
    }

    /**
     * @testdox Method __invoke() returns an unauthorized response when an unknown token is provided.
     */
    public function testInvokeReturnUnauthorizedResponseOnUnknownToken(): void
    {
        $this->tokenManager
            ->method('getTokenById')
            ->with('0e426125-b4f5-4bb6-9628-933dc414d9c3')
            ->will(self::returnValue(null));

        $user = $this
            ->getMockBuilder(User::class)
            ->onlyMethods(['getToken'])
            ->getMock();

        $user
            ->method('getToken')
            ->will(self::returnValue('0e426125-b4f5-4bb6-9628-933dc414d9c3'));

        $activateAccount = new ActivateAccount($this->tokenManager);

        self::assertInstanceOf(Response::class, $activateAccount->__invoke($user));
        self::assertEquals(401, $activateAccount->__invoke($user)->getStatusCode());
    }

    /**
     * @testdox Method __invoke() returns an unauthorized response when an invalid token is provided.
     */
    public function testInvokeReturnUnauthorizedResponseOnInvalidToken(): void
    {
        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $this->tokenManager
            ->method('getTokenById')
            ->with('1cbd794c-cf7c-495e-9d50-0e8a9bf79407')
            ->will(self::returnValue($token));

        $this->tokenManager
            ->method('isTokenValid')
            ->with($token)
            ->will(self::returnValue(false));

        $user = $this
            ->getMockBuilder(User::class)
            ->onlyMethods(['getToken'])
            ->getMock();

        $user
            ->method('getToken')
            ->will(self::returnValue('1cbd794c-cf7c-495e-9d50-0e8a9bf79407'));

        $activateAccount = new ActivateAccount($this->tokenManager);

        self::assertInstanceOf(Response::class, $activateAccount->__invoke($user));
        self::assertEquals(401, $activateAccount->__invoke($user)->getStatusCode());
    }
}
