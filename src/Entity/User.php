<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Controller\Api\User\ActivateAccount;
use App\Controller\Api\User\CurrentUser;
use App\Controller\Api\User\DeleteAccount;
use App\Controller\Api\User\LockAccount;
use App\Controller\Api\User\RequestPasswordReset;
use App\Controller\Api\User\ResetPassword;
use App\Controller\Api\User\UnlockAccount;
use App\Controller\Api\User\UpdateLocale;
use App\Controller\Api\User\UpdatePassword;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'get' => [
            'security' => 'is_granted("ROLE_ADMIN")',
            'normalization_context' => ['groups' => ['read']],
        ],
        'post' => [
            'validation_groups' => ['write'],
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ['read']],
        ],
        'current_user' => [
            'method' => 'get',
            'path' => '/users/current-user',
            'controller' => CurrentUser::class,
            'normalization_context' => ['groups' => ['read']],
        ],
        'request_password_reset' => [
            'method' => 'post',
            'path' => '/users/request-password-reset',
            'controller' => RequestPasswordReset::class,
            'validation_groups' => ['request_password_reset'],
            'denormalization_context' => ['groups' => 'request_password_reset'],
        ],
    ],
    itemOperations: [
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN")',
        ],
        'get' => [
            'security' => 'is_granted("ROLE_ADMIN")',
            'normalization_context' => ['groups' => ['read']],
        ],
        'activate_account' => [
            'method' => 'post',
            'path' => '/users/{id}/activate-account',
            'controller' => ActivateAccount::class,
            'validation_groups' => ['activate_account'],
            'denormalization_context' => ['groups' => 'activate_account'],
        ],
        'delete_account' => [
            'method' => 'post',
            'path' => '/users/{id}/delete-account',
            'controller' => DeleteAccount::class,
            'validation_groups' => ['delete_account'],
            'denormalization_context' => ['groups' => 'delete_account'],
        ],
        'lock_account' => [
            'method' => 'post',
            'path' => '/users/{id}/lock-account',
            'controller' => LockAccount::class,
            'security' => 'is_granted("LOCK_ACCOUNT", object)',
        ],
        'reset_password' => [
            'method' => 'post',
            'path' => '/users/{id}/reset-password',
            'controller' => ResetPassword::class,
            'validation_groups' => ['reset_password'],
            'denormalization_context' => ['groups' => 'reset_password'],
        ],
        'unlock_account' => [
            'method' => 'post',
            'path' => '/users/{id}/unlock-account',
            'controller' => UnlockAccount::class,
            'security' => 'is_granted("UNLOCK_ACCOUNT", object)',
        ],
        'update_locale' => [
            'method' => 'put',
            'path' => '/users/{id}/locale',
            'controller' => UpdateLocale::class,
            'validation_groups' => ['update_locale'],
            'denormalization_context' => ['groups' => ['update_locale']],
        ],
        'update_password' => [
            'method' => 'put',
            'path' => '/users/{id}/password',
            'controller' => UpdatePassword::class,
            'validation_groups' => ['update_password'],
            'denormalization_context' => ['groups' => ['update_password']],
        ],
    ],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']],
    order: ['username' => 'ASC']
)]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(['email'], groups: ['write'])]
#[UniqueEntity(['username'], groups: ['write'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE', region: 'user')]
#[ORM\Table(name: 'user')]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    public const DEFAULT_ROLE = 'ROLE_USER';

    /**
     * @var string The user's current password.
     */
    #[Groups(['update_password', 'delete_account'])]
    #[Assert\NotBlank(groups: ['update_password', 'delete_account'])]
    #[UserPassword(groups: ['update_password', 'delete_account'])]
    protected string $currentPassword;

    /**
     * @var string The user's email address.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_START)]
    #[Groups(['read', 'write', 'request_password_reset'])]
    #[Assert\NotBlank(groups: ['write', 'request_password_reset'])]
    #[Assert\Email(groups: ['write', 'request_password_reset'])]
    #[Assert\Length(max: 180, groups: ['write', 'request_password_reset'])]
    #[ORM\Column(name: 'email', type: 'string', length: 180, unique: true)]
    protected string $email = '';

    /**
     * @var bool Whether the user is enabled.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[ORM\Column(name: 'enabled', type: 'boolean')]
    protected bool $enabled = false;

    /**
     * @var string The user's locale.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_EXACT)]
    #[Groups(['read', 'write', 'update_locale'])]
    #[Assert\NotBlank(groups: ['write', 'update_locale'])]
    #[Assert\Choice(choices: ['en', 'fr'], groups: ['write', 'update_locale'])]
    #[ORM\Column(name: 'locale', type: 'string', length: 2)]
    protected string $locale;

    /**
     * @var bool Whether the user is locked.
     */
    #[ApiFilter(BooleanFilter::class)]
    #[ApiFilter(OrderFilter::class)]
    #[Groups(['read'])]
    #[ORM\Column(name: 'locked', type: 'boolean')]
    protected bool $locked = false;

    /**
     * @var string The user's password.
     */
    #[ORM\Column(name: 'password', type: 'string', length: 200)]
    protected string $password;

    /**
     * @var string|null The user's plain-text password, or null if undefined.
     */
    #[Groups(['write', 'update_password', 'reset_password'])]
    #[Assert\NotBlank(groups: ['write', 'update_password', 'reset_password'])]
    #[Assert\NotCompromisedPassword(groups: ['write', 'update_password', 'reset_password'])]
    #[Assert\NotEqualTo(propertyPath: 'email', groups: ['write', 'update_password', 'reset_password'])]
    #[Assert\NotEqualTo(propertyPath: 'username', groups: ['write', 'update_password', 'reset_password'])]
    #[Assert\Length(min: 8, groups: ['write', 'update_password', 'reset_password'])]
    protected ?string $plainPassword = null;

    /**
     * @var string|null The user's plain-text password confirmation, or null if undefined.
     */
    #[Groups(['write', 'update_password', 'reset_password'])]
    #[Assert\NotBlank(groups: ['write', 'update_password', 'reset_password'])]
    #[Assert\EqualTo(propertyPath: 'plainPassword', groups: ['write', 'update_password', 'reset_password'])]
    protected ?string $plainPasswordConfirmation = null;

    /**
     * @var bool Whether the user has accepted the privacy policy.
     */
    #[Groups(['write'])]
    #[Assert\IsTrue(groups: ['write'])]
    protected bool $privacyPolicy = false;

    /**
     * @var string[] The roles granted to the user.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_PARTIAL)]
    #[Groups(['read'])]
    #[ORM\Column(name: 'roles', type: 'array')]
    protected array $roles = [];

    /**
     * @var string|null The user's validation token, or null if undefined.
     */
    #[Groups(['activate_account', 'reset_password'])]
    #[Assert\NotBlank(groups: ['activate_account', 'reset_password'])]
    protected ?string $token = null;

    /**
     * @var string The user's username.
     */
    #[ApiFilter(OrderFilter::class)]
    #[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_START)]
    #[Groups(['read', 'write'])]
    #[Assert\NotBlank(groups: ['write'])]
    #[Assert\Length(min: 4, max: 30, groups: ['write'])]
    #[ORM\Column(name: 'username', type: 'string', length: 30, unique: true)]
    protected string $username;

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function setCurrentPassword(string $currentPassword): User
    {
        $this->currentPassword = $currentPassword;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): User
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): User
    {
        $this->locale = $locale;
        return $this;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): User
    {
        $this->locked = $locked;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getPlainPasswordConfirmation(): ?string
    {
        return $this->plainPasswordConfirmation;
    }

    public function setPlainPasswordConfirmation(?string $plainPasswordConfirmation): User
    {
        $this->plainPasswordConfirmation = $plainPasswordConfirmation;
        return $this;
    }

    public function isPrivacyPolicy(): bool
    {
        return $this->privacyPolicy;
    }

    public function setPrivacyPolicy(bool $privacyPolicy): User
    {
        $this->privacyPolicy = $privacyPolicy;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = static::DEFAULT_ROLE;

        return array_unique($roles);
    }

    public function addRole(string $role): User
    {
        $role = strtoupper($role);

        if ($role !== static::DEFAULT_ROLE && !in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(string $role): User
    {
        if (($key = array_search(strtoupper($role), $this->roles, true)) !== false) {
            unset($this->roles[$key]);
        }

        return $this;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): User
    {
        $this->token = $token;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}
