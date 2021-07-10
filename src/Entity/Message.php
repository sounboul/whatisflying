<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'validation_groups' => ['write'],
            'normalization_context' => ['groups' => ['write']],
        ],
    ],
    itemOperations: [
        'delete' => ['security' => 'is_granted("ROLE_ADMIN")',],
        'get' => [
            'security' => 'is_granted("ROLE_ADMIN")',
            'normalization_context' => ['groups' => ['write']],
        ],
    ],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']],
    order: ['created' => 'DESC']
)]
#[ApiFilter(PropertyFilter::class)]
#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'message')]
#[ORM\Table(name: 'message')]
class Message
{
    use IdentifiableTrait;
    use TimestampableTrait;

    /**
     * @var string The message content.
     */
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank(groups: ['write'])]
    #[Assert\Length(max: 10000, groups: ['write'])]
    #[ORM\Column(name: 'message', type: 'text')]
    protected string $message;

    /**
     * @var bool Whether the user has accepted the privacy policy.
     */
    #[Groups(['write'])]
    #[Assert\IsTrue(groups: ['write'])]
    protected bool $privacyPolicy = false;

    /**
     * @var string The message sender's email address.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank(groups: ['write'])]
    #[Assert\Email(groups: ['write'])]
    #[Assert\Length(max: 180, groups: ['write'])]
    #[ORM\Column(name: 'sender_address', type: 'string', length: 180)]
    protected string $senderAddress;

    /**
     * @var string The message sender's name.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank(groups: ['write'])]
    #[Assert\Length(max: 100, groups: ['write'])]
    #[ORM\Column(name: 'sender_name', type: 'string', length: 100)]
    protected string $senderName;

    /**
     * @var string The message subject.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank(groups: ['write'])]
    #[Assert\Length(max: 70, groups: ['write'])]
    #[ORM\Column(name: 'subject', type: 'string', length: 70)]
    protected string $subject;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Message
    {
        $this->message = $message;
        return $this;
    }

    public function isPrivacyPolicy(): bool
    {
        return $this->privacyPolicy;
    }

    public function setPrivacyPolicy(bool $privacyPolicy): Message
    {
        $this->privacyPolicy = $privacyPolicy;
        return $this;
    }

    public function getSenderAddress(): string
    {
        return $this->senderAddress;
    }

    public function setSenderAddress(string $senderAddress): Message
    {
        $this->senderAddress = $senderAddress;
        return $this;
    }

    public function getSenderName(): string
    {
        return $this->senderName;
    }

    public function setSenderName(string $senderName): Message
    {
        $this->senderName = $senderName;
        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Message
    {
        $this->subject = $subject;
        return $this;
    }
}
