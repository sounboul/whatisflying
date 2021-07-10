<?php

declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Entity\User;
use App\Service\TokenManager\TokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ActivateAccount extends AbstractController
{
    public function __construct(private TokenManagerInterface $tokenManager)
    {
    }

    public function __invoke(User $data): Response|User
    {
        if (is_null($token = $this->tokenManager->getTokenById($data->getToken()))) {
            return new Response(status: Response::HTTP_UNAUTHORIZED);
        }

        if (!$this->tokenManager->isTokenValid($token, 'activate_account')) {
            $this->tokenManager->deleteToken($token);
            return new Response(status: Response::HTTP_UNAUTHORIZED);
        }

        $data->setEnabled(true);

        return $data;
    }
}
