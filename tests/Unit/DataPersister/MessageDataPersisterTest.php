<?php

declare(strict_types=1);

namespace Tests\Unit\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\DataPersister\MessageDataPersister;
use App\Entity\Message;
use App\Service\Mailer\ContactMailerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class MessageDataPersisterTest extends TestCase
{
    private MockObject|ContactMailerInterface $contactMailer;
    private MockObject|ContextAwareDataPersisterInterface $decorated;

    public function setUp(): void
    {
        $this->contactMailer = $this
            ->getMockBuilder(ContactMailerInterface::class)
            ->getMock();

        $this->decorated = $this
            ->getMockBuilder(ContextAwareDataPersisterInterface::class)
            ->getMock();
    }

    /**
     * @testdox Method supports() calls decorated data persister method.
     */
    public function testSupports(): void
    {
        $data = $this
            ->getMockBuilder(Message::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('supports')
            ->with($data, ['collection_operation_name' => 'post'])
            ->will(self::returnValue(true));

        $messageDataPersister = new MessageDataPersister($this->contactMailer, $this->decorated);

        self::assertEquals(true, $messageDataPersister->supports($data, ['collection_operation_name' => 'post']));
    }

    /**
     * @testdox Method persist() calls decorated data persister method.
     */
    public function testPersist(): void
    {
        $data = $this
            ->getMockBuilder(Message::class)
            ->getMock();

        $result = $this
            ->getMockBuilder(\stdClass::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('persist')
            ->with($data, ['collection_operation_name' => 'POST'])
            ->will(self::returnValue($result));

        $messageDataPersister = new MessageDataPersister($this->contactMailer, $this->decorated);

        self::assertEquals($result, $messageDataPersister->persist($data, ['collection_operation_name' => 'POST']));
    }

    /**
     * @testdox Method persist() sends contact emails.
     */
    public function testPersistSendContactEmail(): void
    {
        $data = $this
            ->getMockBuilder(Message::class)
            ->getMock();

        $result = $this
            ->getMockBuilder(Response::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('persist')
            ->with($data, ['collection_operation_name' => 'post'])
            ->will(self::returnValue($result));

        $this->contactMailer
            ->expects(self::once())
            ->method('sendContactEmail')
            ->with($data);

        $messageDataPersister = new MessageDataPersister($this->contactMailer, $this->decorated);

        self::assertEquals($result, $messageDataPersister->persist($data, ['collection_operation_name' => 'post']));
    }

    /**
     * @testdox Method remove() calls decorated data persister method.
     */
    public function testRemove(): void
    {
        $data = $this
            ->getMockBuilder(Message::class)
            ->getMock();

        $result = $this
            ->getMockBuilder(Response::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('remove')
            ->with($data, ['item_operation_name' => 'delete'])
            ->will(self::returnValue($result));

        $messageDataPersister = new MessageDataPersister($this->contactMailer, $this->decorated);

        self::assertEquals($result, $messageDataPersister->remove($data, ['item_operation_name' => 'delete']));
    }
}
