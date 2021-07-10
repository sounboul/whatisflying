<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'token')]
#[ORM\Table(name: 'token')]
class Token
{
    use IdentifiableTrait;
    use TimestampableTrait;

    /**
     * @var \DateTime The token expiration date and time.
     */
    #[ORM\Column(name: 'expires', type: 'datetime_utc')]
    protected \DateTime $expires;

    /**
     * @var string The token role.
     */
    #[ORM\Column(name: 'role', type: 'string', length: 20)]
    protected string $role;

    /**
     * @var User The user to which the token belongs.
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected User $user;

    public function getExpires(): \DateTime
    {
        return $this->expires;
    }

    public function setExpires(\DateTime $expires): Token
    {
        $this->expires = $expires;
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): Token
    {
        $this->role = $role;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Token
    {
        $this->user = $user;
        return $this;
    }
}
