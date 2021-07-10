<?php

declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Entity\User;
use App\Service\TokenManager\TokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ResetPassword extends AbstractController
{
    public function __construct(private TokenManagerInterface $tokenManager)
    {
    }

    public function __invoke(User $data): Response|User
    {
        if (is_null($token = $this->tokenManager->getTokenById($data->getToken()))) {
            return new Response(status: Response::HTTP_UNAUTHORIZED);
        }

        if (!$this->tokenManager->isTokenValid($token, 'reset_password')) {
            $this->tokenManager->deleteToken($token);
            return new Response(status: Response::HTTP_UNAUTHORIZED);
        }

        // Set the encoded password to an empty string to force the entity being marked as dirty.
        $data->setPassword('');

        return $data;
    }
}
