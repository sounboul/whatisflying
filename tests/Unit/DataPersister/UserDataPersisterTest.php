<?php

declare(strict_types=1);

namespace Tests\Unit\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\DataPersister\UserDataPersister;
use App\Entity\Token;
use App\Entity\User;
use App\Service\Mailer\UserMailerInterface;
use App\Service\TokenManager\TokenManagerInterface;
use App\Service\UserManager\UserManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\DataPersister\UserDataPersister
 */
final class UserDataPersisterTest extends TestCase
{
    private MockObject|ContextAwareDataPersisterInterface $decorated;
    private MockObject|TokenManagerInterface $tokenManager;
    private MockObject|UserManagerInterface $userManager;
    private MockObject|UserMailerInterface $userMailer;

    public function setUp(): void
    {
        $this->decorated = $this
            ->getMockBuilder(ContextAwareDataPersisterInterface::class)
            ->getMock();

        $this->tokenManager = $this
            ->getMockBuilder(TokenManagerInterface::class)
            ->getMock();

        $this->userManager = $this
            ->getMockBuilder(UserManagerInterface::class)
            ->getMock();

        $this->userMailer = $this
            ->getMockBuilder(UserMailerInterface::class)
            ->getMock();
    }

    /**
     * @testdox Method supports() calls decorated data persister method.
     */
    public function testSupports(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('supports')
            ->with($data, ['collection_operation_name' => 'post'])
            ->will(self::returnValue(true));

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertEquals(true, $userDataPersister->supports($data, ['collection_operation_name' => 'post']));
    }

    /**
     * @testdox Method persist() calls decorated data persister method.
     */
    public function testPersist(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $result = $this
            ->getMockBuilder(Response::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('persist')
            ->with($data, ['item_operation_name' => 'get'])
            ->will(self::returnValue($result));

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertEquals($result, $userDataPersister->persist($data, ['item_operation_name' => 'get']));
    }

    /**
     * @testdox Method persist() sends account activation email.
     */
    public function testPersistSendAccountActivationEmail(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $result = $this
            ->getMockBuilder(Response::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('persist')
            ->with($data, ['collection_operation_name' => 'post'])
            ->will(self::returnValue($result));

        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $this->tokenManager
            ->expects(self::once())
            ->method('generateToken')
            ->with($data, 'activate_account')
            ->will(self::returnValue($token));

        $this->userMailer
            ->expects(self::once())
            ->method('sendAccountActivationEmail')
            ->with($data, $token);

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertEquals($result, $userDataPersister->persist($data, ['collection_operation_name' => 'post']));
    }

    /**
     * @testdox Method persist() sends password reset email.
     */
    public function testPersistSendPasswordResetEmail(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $data
            ->method('getEmail')
            ->will(self::returnValue('john.doe'));

        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $this->tokenManager
            ->expects(self::once())
            ->method('generateToken')
            ->with($data, 'reset_password')
            ->will(self::returnValue($token));

        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->userManager
            ->method('getUserByEmail')
            ->with('john.doe')
            ->will(self::returnValue($user));

        $this->userMailer
            ->expects(self::once())
            ->method('sendPasswordResetEmail')
            ->with($user, $token);

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertInstanceOf(
            Response::class,
            $userDataPersister->persist($data, ['collection_operation_name' => 'request_password_reset'])
        );
    }

    /**
     * @testdox Method persist() activates account.
     */
    public function testPersistActivateAccount(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $data
            ->method('getToken')
            ->will(self::returnValue('0cc142ed-e0b5-4576-af9f-2c26be767b86'));

        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $this->tokenManager
            ->method('getTokenById')
            ->with('0cc142ed-e0b5-4576-af9f-2c26be767b86')
            ->will(self::returnValue($token));

        $this->tokenManager
            ->expects(self::once())
            ->method('deleteToken')
            ->with($token);

        $this->userManager
            ->expects(self::once())
            ->method('enableUser')
            ->with($data);

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertInstanceOf(
            Response::class,
            $userDataPersister->persist($data, ['item_operation_name' => 'activate_account'])
        );
    }

    /**
     * @testdox Method persist() resets password.
     */
    public function testPersistResetPassword(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $data
            ->method('getToken')
            ->will(self::returnValue('dac57285-917c-4827-b136-9d64c4b43be1'));

        $token = $this
            ->getMockBuilder(Token::class)
            ->getMock();

        $this->tokenManager
            ->method('getTokenById')
            ->with('dac57285-917c-4827-b136-9d64c4b43be1')
            ->will(self::returnValue($token));

        $this->tokenManager
            ->expects(self::once())
            ->method('deleteToken')
            ->with($token);

        $result = $this
            ->getMockBuilder(Response::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('persist')
            ->with($data, ['item_operation_name' => 'reset_password'])
            ->will(self::returnValue($result));

        $this->userMailer
            ->expects(self::once())
            ->method('sendPasswordChangedEmail')
            ->with($data);

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertInstanceOf(
            Response::class,
            $userDataPersister->persist($data, ['item_operation_name' => 'reset_password'])
        );
    }

    /**
     * @testdox Method persist() deletes account.
     */
    public function testPersistDeleteAccount(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->userManager
            ->expects(self::once())
            ->method('deleteUser')
            ->with($data);

        $this->userMailer
            ->expects(self::once())
            ->method('sendAccountDeletedEmail')
            ->with($data);

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertInstanceOf(
            Response::class,
            $userDataPersister->persist($data, ['item_operation_name' => 'delete_account'])
        );
    }

    /**
     * @testdox Method persist() locks account.
     */
    public function testPersistLockAccount(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->userManager
            ->expects(self::once())
            ->method('lockUser')
            ->with($data);

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertInstanceOf(
            Response::class,
            $userDataPersister->persist($data, ['item_operation_name' => 'lock_account'])
        );
    }

    /**
     * @testdox Method persist() unlocks account.
     */
    public function testPersistUnlockAccount(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->userManager
            ->expects(self::once())
            ->method('unlockUser')
            ->with($data);

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertInstanceOf(
            Response::class,
            $userDataPersister->persist($data, ['item_operation_name' => 'unlock_account'])
        );
    }

    /**
     * @testdox Method remove() calls decorated data persister method.
     */
    public function testRemove(): void
    {
        $data = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $result = $this
            ->getMockBuilder(Response::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('remove')
            ->with($data, ['item_operation_name' => 'delete'])
            ->will(self::returnValue($result));

        $userDataPersister = new UserDataPersister(
            $this->decorated,
            $this->tokenManager,
            $this->userManager,
            $this->userMailer
        );

        self::assertEquals($result, $userDataPersister->remove($data, ['item_operation_name' => 'delete']));
    }
}
