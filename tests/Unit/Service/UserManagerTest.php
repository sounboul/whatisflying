<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Entity\User;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Service\UserManager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Service\UserManager\UserManager
 */
final class UserManagerTest extends TestCase
{
    private MockObject|UserRepository $userRepository;
    private MockObject|EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->userRepository = $this
            ->getMockBuilder(TokenRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->onlyMethods(['flush', 'getRepository', 'persist', 'remove'])
            ->getMockForAbstractClass();

        $this->entityManager
            ->method('getRepository')
            ->with(User::class)
            ->will(self::returnValue($this->userRepository));
    }

    /**
     * @testdox Method createUser() creates the user.
     */
    public function testCreateUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->entityManager
            ->expects(self::once())
            ->method('persist')
            ->with($user);

        $this->entityManager
            ->expects(self::once())
            ->method('flush');

        $userManager = new UserManager($this->entityManager);
        $userManager->createUser($user);
    }

    /**
     * @testdox Method deleteUser() deletes the user.
     */
    public function testDeleteUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $this->entityManager
            ->expects(self::once())
            ->method('remove')
            ->with($user);

        $this->entityManager
            ->expects(self::once())
            ->method('flush');

        $userManager = new UserManager($this->entityManager);
        $userManager->deleteUser($user);
    }

    /**
     * @testdox Method enableUser() enables the user.
     */
    public function testEnableUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->onlyMethods(['setEnabled'])
            ->getMock();

        $user
            ->expects(self::once())
            ->method('setEnabled')
            ->with(true);

        $this->entityManager
            ->expects(self::once())
            ->method('persist')
            ->with($user);

        $this->entityManager
            ->expects(self::once())
            ->method('persist');

        $userManager = new UserManager($this->entityManager);
        $userManager->enableUser($user);
    }

    /**
     * @testdox Method getUserByEmail() returns the user or null if not found.
     */
    public function testGetUserByEmailReturnUserOrNull(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $valueMap = [
            [['email' => 'john.doe@nowhere.tld'], null, $user],
            [['email' => 'johanna.doe@nowhere.tld'], null, null],
        ];

        $this->userRepository
            ->method('findOneBy')
            ->will(self::returnValueMap($valueMap));

        $userManager = new UserManager($this->entityManager);

        self::assertEquals($user, $userManager->getUserByEmail('john.doe@nowhere.tld'));
        self::assertEquals(null, $userManager->getUserByEmail('johanna.doe@nowhere.tld'));
    }

    /**
     * @testdox Method getUserByUsername() returns the user or null if not found.
     */
    public function testGetUserByUsernameReturnUserOrNull(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $valueMap = [
            [['username' => 'john.doe'], null, $user],
            [['username' => 'johanna.doe'], null, null],
        ];

        $this->userRepository
            ->method('findOneBy')
            ->will(self::returnValueMap($valueMap));

        $userManager = new UserManager($this->entityManager);

        self::assertEquals($user, $userManager->getUserByUsername('john.doe'));
        self::assertEquals(null, $userManager->getUserByUsername('johanna.doe'));
    }

    /**
     * @testdox Method lockUser() locks the user.
     */
    public function testLockUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $user
            ->expects(self::once())
            ->method('setLocked')
            ->with(true);

        $this->entityManager
            ->expects(self::once())
            ->method('persist')
            ->with($user);

        $this->entityManager
            ->expects(self::once())
            ->method('persist');

        $userManager = new UserManager($this->entityManager);
        $userManager->lockUser($user);
    }

    /**
     * @testdox Method unlockUser() unlocks the user.
     */
    public function testUnlockUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $user
            ->expects(self::once())
            ->method('setLocked')
            ->with(false);

        $this->entityManager
            ->expects(self::once())
            ->method('persist')
            ->with($user);

        $this->entityManager
            ->expects(self::once())
            ->method('persist');

        $userManager = new UserManager($this->entityManager);
        $userManager->unlockUser($user);
    }
}
