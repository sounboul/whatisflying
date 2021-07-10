<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Message;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Message
 */
final class MessageTest extends TestCase
{
    /**
     * @testdox Sets/gets the message content.
     */
    public function testMessage(): void
    {
        $message = new Message();
        $message->setMessage('Lorem ipsum dolor sit amet');

        self::assertEquals('Lorem ipsum dolor sit amet', $message->getMessage());
    }

    /**
     * @testdox Sets/gets whether the user has accepted the privacy policy.
     */
    public function testPrivacyPolicy(): void
    {
        $message = new Message();
        $message->setPrivacyPolicy(true);

        self::assertEquals(true, $message->isPrivacyPolicy());
    }

    /**
     * @testdox Sets/gets the message sender's email address.
     */
    public function testSenderAddress(): void
    {
        $message = new Message();
        $message->setSenderAddress('john.doe@nowhere.tld');

        self::assertEquals('john.doe@nowhere.tld', $message->getSenderAddress());
    }

    /**
     * @testdox Sets/gets the message sender's name.
     */
    public function testSenderName(): void
    {
        $message = new Message();
        $message->setSenderName('John Doe');

        self::assertEquals('John Doe', $message->getSenderName());
    }

    /**
     * @testdox Sets/gets the message subject.
     */
    public function testSubject(): void
    {
        $message = new Message();
        $message->setSubject('Mollitia molestiae eos maxime aut');

        self::assertEquals('Mollitia molestiae eos maxime aut', $message->getSubject());
    }
}
