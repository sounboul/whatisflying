<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Message;
use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<Message>
 */
class MessageRepository extends EntityRepository
{

}
