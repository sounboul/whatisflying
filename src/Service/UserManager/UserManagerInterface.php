<?php

declare(strict_types=1);

namespace App\Service\UserManager;

use App\Entity\User;

interface UserManagerInterface
{
    /**
     * Creates a user.
     *
     * @param User $user
     */
    public function createUser(User $user): void;

    /**
     * Deletes a user.
     *
     * @param User $user
     */
    public function deleteUser(User $user): void;

    /**
     * Enables a user.
     *
     * @param User $user
     */
    public function enableUser(User $user): void;

    /**
     * Finds a user by its email address and returns it.
     *
     * @param string $email The user's email address.
     *
     * @return User|null The user, or null if not found.
     */
    public function getUserByEmail(string $email): ?User;

    /**
     * Finds a user by its username and returns it.
     *
     * @param string $username The user's username.
     *
     * @return User|null The user, or null if not found.
     */
    public function getUserByUsername(string $username): ?User;

    /**
     * Locks a user.
     *
     * @param User $user
     */
    public function lockUser(User $user): void;

    /**
     * Unlocks a user.
     *
     * @param User $user
     */
    public function unlockUser(User $user): void;
}
