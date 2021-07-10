<?php

declare(strict_types=1);

namespace Tests\Unit\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\UserProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @covers \App\Security\UserProvider
 */
final class UserProviderTest extends TestCase
{
    private MockObject|UserRepository $userRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->userRepository = $this
            ->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['getRepository'])
            ->getMockForAbstractClass();

        $this->entityManager
            ->method('getRepository')
            ->with(User::class)
            ->will(self::returnValue($this->userRepository));
    }

    /**
     * @testdox Method loadUserByIdentifier() returns the user.
     */
    public function testLoadUserByIdentifierReturnUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->userRepository
            ->method('findOneBy')
            ->with(['username' => 'Alan_B748'])
            ->will(self::returnValue($user));

        $userProvider = new UserProvider($this->entityManager);

        self::assertEquals($user, $userProvider->loadUserByIdentifier('Alan_B748'));
    }

    /**
     * @testdox Method loadUserByUsername() returns the user.
     */
    public function testLoadUserByUsernameReturnUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->userRepository
            ->method('findOneBy')
            ->with(['username' => 'noah-777'])
            ->will(self::returnValue($user));

        $userProvider = new UserProvider($this->entityManager);

        self::assertEquals($user, $userProvider->loadUserByUsername('noah-777'));
    }

    /**
     * @testdox Method loadUserByUsername() throws when the user is not found.
     */
    public function testLoadUserByUsernameThrowOnUserNotFound(): void
    {
        $this->userRepository
            ->method('findOneBy')
            ->with(['username' => '99lufthansaballons'])
            ->will(self::returnValue(null));

        $userProvider = new UserProvider($this->entityManager);

        self::expectException(UserNotFoundException::class);
        $userProvider->loadUserByUsername('99lufthansaballons');
    }

    /**
     * @testdox Method refreshUser() returns the user.
     */
    public function testRefreshUserReturnUser(): void
    {
        $user = new User();
        $user->setUsername('bird-goes-splash');

        $this->userRepository
            ->method('findOneBy')
            ->with(['username' => 'bird-goes-splash'])
            ->will(self::returnValue($user));

        $userProvider = new UserProvider($this->entityManager);

        self::assertEquals($user, $userProvider->refreshUser($user));
    }

    /**
     * @testdox Method refreshUser() throws when an unsupported user is provided.
     */
    public function testRefreshUserThrowOnUnsupportedUser(): void
    {
        $user = $this->getMockForAbstractClass(UserInterface::class);
        $userProvider = new UserProvider($this->entityManager);

        self::expectException(UnsupportedUserException::class);

        $userProvider->refreshUser($user);
    }

    /**
     * @testdox Method refreshUser() throws when the user is not found.
     */
    public function testRefreshUserThrowOnUserNotFound(): void
    {
        $user = new User();
        $user->setUsername('BoingBoing737');

        $this->userRepository
            ->method('findOneBy')
            ->with(['username' => 'BoingBoing737'])
            ->will(self::returnValue(null));

        $userProvider = new UserProvider($this->entityManager);

        self::expectException(UserNotFoundException::class);

        $userProvider->refreshUser($user);
    }

    /**
     * @testdox Method supportsClass() returns true when the user is supported.
     */
    public function testSupportsClassReturnTrueOnSupportedUser(): void
    {
        $userProvider = new UserProvider($this->entityManager);

        self::assertEquals(true, $userProvider->supportsClass(User::class));
    }

    /**
     * @testdox Method supportsClass() returns false when the user is unsupported.
     */
    public function testSupportsClassReturnFalseOnUnsupportedUser(): void
    {
        $userProvider = new UserProvider($this->entityManager);

        self::assertEquals(false, $userProvider->supportsClass('\AnotherClass'));
    }
}
