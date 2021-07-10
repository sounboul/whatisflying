<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use App\Service\TokenManager\TokenManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Service\TokenManager\TokenManager
 */
final class TokenManagerTest extends TestCase
{
    private MockObject|TokenRepository $tokenRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->tokenRepository = $this
            ->getMockBuilder(TokenRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findLatestValidTokenByUserAndRole', 'findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $this->entityManager
            ->method('getRepository')
            ->with(Token::class)
            ->will(self::returnValue($this->tokenRepository));
    }

    /**
     * @testdox Method deleteToken() deletes the token.
     */
    public function testDeleteToken(): void
    {
        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $this->entityManager
            ->expects(self::once())
            ->method('remove')
            ->with($token);

        $this->entityManager
            ->expects(self::once())
            ->method('flush');

        $tokenManager = new TokenManager($this->entityManager);
        $tokenManager->deleteToken($token);
    }

    /**
     * @testdox Method generateToken() returns an existing token if one exists.
     */
    public function testGenerateTokenReturnExistingToken(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $this->tokenRepository
            ->method('findLatestValidTokenByUserAndRole')
            ->with($user, 'reset_password')
            ->will(self::returnValue($token));

        $tokenManager = new TokenManager($this->entityManager);

        self::assertEquals($token, $tokenManager->generateToken($user, 'reset_password'));
    }

    /**
     * @testdox Method generateToken() returns a new token if none exists.
     */
    public function testGenerateTokenReturnNewToken(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->tokenRepository
            ->method('findLatestValidTokenByUserAndRole')
            ->with($user, 'reset_password')
            ->will(self::returnValue(null));

        $tokenManager = new TokenManager($this->entityManager);
        $token = $tokenManager->generateToken($user, 'reset_password', 86400);

        self::assertEquals($user, $token->getUser());
        self::assertEquals('reset_password', $token->getRole());
    }

    /**
     * @testdox Method getTokenById() returns the token or null if not found.
     */
    public function testGetTokenByIdReturnTokenOrNull(): void
    {
        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $valueMap = [
            [['id' => '289651af-0f8c-4007-bca5-f4c45b8b1891'], null, $token],
            [['id' => 'e9a7ba0f-514f-4b6e-9d71-c5e5cff0af84'], null, null],
        ];

        $this->tokenRepository
            ->method('findOneBy')
            ->will(self::returnValueMap($valueMap));

        $tokenManager = new TokenManager($this->entityManager);

        self::assertEquals($token, $tokenManager->getTokenById('289651af-0f8c-4007-bca5-f4c45b8b1891'));
        self::assertEquals(null, $tokenManager->getTokenById('e9a7ba0f-514f-4b6e-9d71-c5e5cff0af84'));
    }

    /**
     * @testdox Method isTokenValid() returns whether a token is valid.
     */
    public function testGetTokenIsValid(): void
    {
        $validToken = $this
            ->getMockBuilder(Token::class)
            ->onlyMethods(['getExpires', 'getRole'])
            ->getMock();

        $validToken
            ->method('getRole')
            ->will(self::returnValue('reset_password'));

        $validToken
            ->method('getExpires')
            ->will(self::returnValue(new \DateTime('2050-12-31')));

        $invalidToken = $this
            ->getMockBuilder(Token::class)
            ->onlyMethods(['getExpires', 'getRole'])
            ->getMock();

        $invalidToken
            ->method('getRole')
            ->will(self::returnValue('activate_account'));

        $invalidToken
            ->method('getExpires')
            ->will(self::returnValue(new \DateTime('2050-12-31')));

        $expiredToken = $this
            ->getMockBuilder(Token::class)
            ->onlyMethods(['getExpires', 'getRole'])
            ->getMock();

        $expiredToken
            ->method('getRole')
            ->will(self::returnValue('reset_password'));

        $expiredToken
            ->method('getExpires')
            ->will(self::returnValue(new \DateTime('1970-01-01')));

        $tokenManager = new TokenManager($this->entityManager);

        self::assertEquals(true, $tokenManager->isTokenValid($validToken, 'reset_password'));
        self::assertEquals(false, $tokenManager->isTokenValid($invalidToken, 'reset_password'));
        self::assertEquals(false, $tokenManager->isTokenValid($expiredToken, 'reset_password'));
    }
}
