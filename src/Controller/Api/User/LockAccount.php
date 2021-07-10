<?php

declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class LockAccount extends AbstractController
{
    public function __invoke(User $data): User
    {
        return $data;
    }
}
