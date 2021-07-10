<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

abstract class AbstractMailer
{
    protected LoggerInterface $logger;
    protected MailerInterface $mailer;

    /**
     * Sends an email.
     *
     * @param string  $senderAddress    The email sender's address.
     * @param string  $senderName       The email sender's name.
     * @param string  $recipientAddress The email recipient's address.
     * @param string  $recipientName    The email recipient's name.
     * @param string  $subject          The email subject.
     * @param string  $template         The template to use to render the email content.
     * @param mixed[] $context          An optional context to render the email content.
     * @param int     $priority         An optional email priority. Defaults to normal priority.
     */
    protected function sendEmail(
        string $senderAddress,
        string $senderName,
        string $recipientAddress,
        string $recipientName,
        string $subject,
        string $template,
        array $context = [],
        int $priority = Email::PRIORITY_NORMAL
    ): void {
        $email = new TemplatedEmail();
        $email
            ->from(new Address($senderAddress, $senderName))
            ->to(new Address($recipientAddress, $recipientName))
            ->subject($subject)
            ->htmlTemplate($template)
            ->priority($priority)
            ->context($context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
