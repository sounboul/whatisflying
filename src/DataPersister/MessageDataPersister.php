<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Message;
use App\Service\Mailer\ContactMailerInterface;

final class MessageDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private ContactMailerInterface $contactMailer,
        private ContextAwareDataPersisterInterface $decorated
    ) {
    }

    /**
     * @param mixed   $data
     * @param mixed[] $context
     *
     * @return bool
     */
    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    /**
     * @param mixed   $data
     * @param mixed[] $context
     *
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        if ($data instanceof Message && ($context['collection_operation_name'] ?? null) === 'post') {
            $result = $this->decorated->persist($data, $context);
            $this->contactMailer->sendContactEmail($data);
            return $result;
        }

        return $this->decorated->persist($data, $context);
    }

    /**
     * @param mixed   $data
     * @param mixed[] $context
     *
     * @return object|void
     */
    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}
