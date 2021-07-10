<?php

declare(strict_types=1);

namespace App\Controller\Api\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

final class CurrentUser extends AbstractController
{
    public function __construct(private Security $security)
    {
    }

    public function __invoke(Request $request): UserInterface
    {
        return $this->security->getUser();
    }
}
