<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use App\Entity\Message;

interface ContactMailerInterface
{
    /**
     * Send a message to the contact address.
     *
     * @param Message $message The message sent via the contact form.
     */
    public function sendContactEmail(Message $message): void;
}
