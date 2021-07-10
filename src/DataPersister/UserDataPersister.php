<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Service\Mailer\UserMailerInterface;
use App\Service\TokenManager\TokenManagerInterface;
use App\Service\UserManager\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private ContextAwareDataPersisterInterface $decorated,
        private TokenManagerInterface $tokenManager,
        private UserManagerInterface $userManager,
        private UserMailerInterface $userMailer
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
        if ($data instanceof User && ($context['collection_operation_name'] ?? null) === 'post') {
            $result = $this->decorated->persist($data, $context);
            $token = $this->tokenManager->generateToken($data, 'activate_account', 86400);
            $this->userMailer->sendAccountActivationEmail($data, $token);

            return $result;
        }

        if ($data instanceof User && ($context['collection_operation_name'] ?? null) === 'request_password_reset') {
            if (!is_null($user = $this->userManager->getUserByEmail($data->getEmail()))) {
                $token = $this->tokenManager->generateToken($user, 'reset_password');
                $this->userMailer->sendPasswordResetEmail($user, $token);
            }

            return new Response(status: Response::HTTP_NO_CONTENT);
        }

        if ($data instanceof User && ($context['item_operation_name'] ?? null) === 'activate_account') {
            $this->userManager->enableUser($data);
            $token = $this->tokenManager->getTokenById($data->getToken());
            $this->tokenManager->deleteToken($token);

            return new Response(status: Response::HTTP_NO_CONTENT);
        }

        if ($data instanceof User && ($context['item_operation_name'] ?? null) === 'delete_account') {
            $this->userManager->deleteUser($data);
            $this->userMailer->sendAccountDeletedEmail($data);

            return new Response(status: Response::HTTP_NO_CONTENT);
        }

        if ($data instanceof User && ($context['item_operation_name'] ?? null) === 'lock_account') {
            $this->userManager->lockUser($data);

            return new Response(status: Response::HTTP_NO_CONTENT);
        }

        if ($data instanceof User && ($context['item_operation_name'] ?? null) === 'reset_password') {
            $this->decorated->persist($data, $context);
            $this->userMailer->sendPasswordChangedEmail($data);
            $token = $this->tokenManager->getTokenById($data->getToken());
            $this->tokenManager->deleteToken($token);

            return new Response(status: Response::HTTP_NO_CONTENT);
        }

        if ($data instanceof User && ($context['item_operation_name'] ?? null) === 'unlock_account') {
            $this->userManager->unlockUser($data);

            return new Response(status: Response::HTTP_NO_CONTENT);
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
