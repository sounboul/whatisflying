<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use App\Entity\Token;
use App\Entity\User;

interface UserMailerInterface
{
    /**
     * Sends the account activation email to a user.
     *
     * The email subject and content are translated based on the user's locale.
     *
     * @param User  $user  The user to whom the email will be sent.
     * @param Token $token The token enabling the account activation.
     */
    public function sendAccountActivationEmail(User $user, Token $token): void;

    /**
     * Sends the account deletion confirmation email to a user.
     *
     * The email subject and content are translated based on the user's locale.
     *
     * @param User $user The user to whom the email will be sent.
     */
    public function sendAccountDeletedEmail(User $user): void;

    /**
     * Sends the password changed notification email to a user.
     *
     * The email subject and content are translated based on the user's locale.
     *
     * @param User $user The user to whom the email will be sent.
     */
    public function sendPasswordChangedEmail(User $user): void;

    /**
     * Sends the password reset email to a user.
     *
     * The email subject and content are translated based on the user's locale.
     *
     * @param User  $user  The user to whom the email will be sent.
     * @param Token $token The token enabling the password reset.
     */
    public function sendPasswordResetEmail(User $user, Token $token): void;
}
