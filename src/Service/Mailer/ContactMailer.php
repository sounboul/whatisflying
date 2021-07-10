<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use App\Entity\Message;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;

final class ContactMailer extends AbstractMailer implements ContactMailerInterface
{
    public function __construct(
        protected LoggerInterface $logger,
        protected MailerInterface $mailer,
        private string $recipientAddress,
        private string $recipientName
    ) {
    }

    public function sendContactEmail(Message $message): void
    {
        $this->sendEmail(
            $message->getSenderAddress(),
            $message->getSenderName(),
            $this->recipientAddress,
            $this->recipientName,
            $message->getSubject(),
            'email/contact.mjml.twig',
            [
                'message' => $message->getMessage(),
                'subject' => $message->getSubject()
            ]
        );
    }
}
