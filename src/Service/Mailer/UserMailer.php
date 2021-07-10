<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use App\Entity\Token;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class UserMailer extends AbstractMailer implements UserMailerInterface
{
    public function __construct(
        protected LoggerInterface $logger,
        protected MailerInterface $mailer,
        private TranslatorInterface $translator,
        private string $senderAddress,
        private string $senderName
    ) {
    }

    public function sendAccountActivationEmail(User $user, Token $token): void
    {
        $subject = $this->translator->trans('user.account_activation.subject', [], 'emails', $user->getLocale());
        $template = 'email/user/account_activation.mjml.twig';

        $this->sendUserEmail($user, $subject, $template, ['token' => $token]);
    }

    public function sendAccountDeletedEmail(User $user): void
    {
        $subject = $this->translator->trans('user.account_deleted.subject', [], 'emails', $user->getLocale());
        $template = 'email/user/account_deleted.mjml.twig';

        $this->sendUserEmail($user, $subject, $template);
    }

    public function sendPasswordChangedEmail(User $user): void
    {
        $subject = $this->translator->trans('user.password_changed.subject', [], 'emails', $user->getLocale());
        $template = 'email/user/password_changed.mjml.twig';

        $this->sendUserEmail($user, $subject, $template);
    }

    public function sendPasswordResetEmail(User $user, Token $token): void
    {
        $subject = $this->translator->trans('user.password_reset.subject', [], 'emails', $user->getLocale());
        $template = 'email/user/password_reset.mjml.twig';

        $this->sendUserEmail($user, $subject, $template, ['token' => $token]);
    }

    /**
     * Sends an email to a user.
     *
     * @param User    $user         The user to whom the email will be sent.
     * @param string  $subject      The email subject.
     * @param string  $template     The template to use to render the email content.
     * @param mixed[] $extraContext An optional context to render the email content.
     */
    private function sendUserEmail(User $user, string $subject, string $template, array $extraContext = []): void
    {
        $this->sendEmail(
            $this->senderAddress,
            $this->senderName,
            $user->getEmail(),
            $user->getUsername(),
            $subject,
            $template,
            array_merge(
                $extraContext,
                [
                    'locale' => $user->getLocale(),
                    'subject' => $subject,
                    'user' => $user,
                ]
            )
        );
    }
}
