<?php

declare(strict_types=1);

namespace App\Service\TokenManager;

use App\Entity\Token;
use App\Entity\User;

interface TokenManagerInterface
{
    /**
     * Deletes a token.
     *
     * @param Token $token The token to delete.
     */
    public function deleteToken(Token $token): void;

    /**
     * Generates a token.
     *
     * @param User   $user The user for whom the token will be generated.
     * @param string $role The token role.
     * @param int    $ttl  The token TTL, in seconds. Defaults to 3600 seconds.
     *
     * @return Token The generated token.
     */
    public function generateToken(User $user, string $role, int $ttl = 3600): Token;

    /**
     * Finds a token by its ID and returns it.
     *
     * @param string $id The token ID.
     *
     * @return Token|null The token, or null if not found.
     */
    public function getTokenById(string $id): ?Token;

    /**
     * Returns whether a token is valid.
     * 
     * A token is considered valid if its role matches the expected role, and it's not expired yet.
     *
     * @param Token  $token        The token to be checked.
     * @param string $expectedRole The expected token role.
     *
     * @return bool Whether the token is valid.
     */
    public function isTokenValid(Token $token, string $expectedRole): bool;
}
