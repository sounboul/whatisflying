<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\User
 */
final class UserTest extends TestCase
{
    /**
     * @testdox Sets/gets the user current password.
     */
    public function testCurrentPassword(): void
    {
        $user = new User();
        $user->setCurrentPassword('PM3jcqaP');

        self::assertEquals('PM3jcqaP', $user->getCurrentPassword());
    }

    /**
     * @testdox Sets/gets the user email address.
     */
    public function testEmail(): void
    {
        $user = new User();
        $user->setEmail('john.doe@nowhere.tld');

        self::assertEquals('john.doe@nowhere.tld', $user->getEmail());
    }

    /**
     * @testdox Sets/gets whether the user is enabled.
     */
    public function testEnabled(): void
    {
        $user = new User();
        $user->setEnabled(true);

        self::assertEquals(true, $user->isEnabled());
    }

    /**
     * @testdox Sets/gets the user locale.
     */
    public function testLocale(): void
    {
        $user = new User();
        $user->setLocale('fr');

        self::assertEquals('fr', $user->getLocale());
    }

    /**
     * @testdox Sets/gets whether the user is locked.
     */
    public function testLocked(): void
    {
        $user = new User();
        $user->setLocked(true);

        self::assertEquals(true, $user->isLocked());
    }

    /**
     * @testdox Sets/gets the password used to authenticate the user.
     */
    public function testPassword(): void
    {
        $user = new User();
        $user->setPassword('$2y$10$16GR6iwd1RRBN6K3BSnih.F/XbaqystWW0ZfYUxUtSMczdB9adQSa');

        self::assertEquals('$2y$10$16GR6iwd1RRBN6K3BSnih.F/XbaqystWW0ZfYUxUtSMczdB9adQSa', $user->getPassword());
    }

    /**
     * @testdox Sets/gets the plain-text password used to authenticate the user.
     */
    public function testPlainPassword(): void
    {
        $user = new User();
        $user->setPlainPassword('P8gKR3Qw');

        self::assertEquals('P8gKR3Qw', $user->getPlainPassword());
    }

    /**
     * @testdox Sets/gets the confirmation of the plain-text password used to authenticate the user.
     */
    public function testPlainPasswordConfirmation(): void
    {
        $user = new User();
        $user->setPlainPasswordConfirmation('5JAq6hqj');

        self::assertEquals('5JAq6hqj', $user->getPlainPasswordConfirmation());
    }

    /**
     * @testdox Sets/gets whether the user has accepted the privacy policy.
     */
    public function testPrivacyPolicy(): void
    {
        $user = new User();
        $user->setPrivacyPolicy(true);

        self::assertEquals(true, $user->isPrivacyPolicy());
    }

    /**
     * @testdox Sets/gets the roles granted to the user.
     */
    public function testRoles(): void
    {
        $user = new User();

        self::assertCount(1, $user->getRoles());
        self::assertContains(User::DEFAULT_ROLE, $user->getRoles());

        $roles = ['FIRST_ROLE', 'SECOND_ROLE'];
        $user->setRoles($roles);

        self::assertCount(3, $user->getRoles());

        $user->addRole('THIRD_ROLE');
        $user->addRole('THIRD_ROLE');

        self::assertCount(4, $user->getRoles());

        $user->removeRole('FIRST_ROLE');

        self::assertCount(3, $user->getRoles());
    }

    /**
     * @testdox Sets/gets the token used to confirm user actions.
     */
    public function testToken(): void
    {
        $user = new User();
        $user->setToken('75ed82d1-02f7-465f-b098-efddc778b51d');

        self::assertEquals('75ed82d1-02f7-465f-b098-efddc778b51d', $user->getToken());
    }

    /**
     * @testdox Sets/gets the username used to authenticate the user.
     */
    public function testUsername(): void
    {
        $user = new User();
        $user->setUsername('johndoe');

        self::assertEquals('johndoe', $user->getUsername());
    }

    /**
     * @testdox Method getUserIdentifier() returns the username used to authenticate the user.
     */
    public function testGetUserIdentifier(): void
    {
        $user = new User();
        $user->setUsername('MaxGoesBoingBoing');

        self::assertEquals('MaxGoesBoingBoing', $user->getUserIdentifier());
    }

    /**
     * @testdox Method getSalt() returns null.
     */
    public function testGetSalt(): void
    {
        $user = new User();

        self::assertEquals(null, $user->getSalt());
    }

    /**
     * @testdox Method eraseCredentials() erases the plain-text password used to authenticate the user.
     */
    public function testEraseCredentials(): void
    {
        $user = new User();
        $user->setPlainPassword('JMYMufR6')
             ->eraseCredentials();

        self::assertEquals(null, $user->getPlainPassword());
    }
}
