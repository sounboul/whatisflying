<?php

declare(strict_types=1);

namespace Tests\Unit\Security\Voter;

use App\Entity\User;
use App\Security\Voter\UserVoter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;

final class UserVoterTest extends TestCase
{
    private MockObject|Security $security;

    public function setUp(): void
    {
        $this->security = $this
            ->getMockBuilder(Security::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @testdox Method supports() returns whether à given attribute & subject are supported.
     */
    public function testSupports(): void
    {
        $userVoter = new UserVoter($this->security);

        $subject = $this
            ->getMockBuilder(User::class)
            ->getMock();

        self::assertEquals(true, $this->callProtectedMethod($userVoter, 'supports', 'LOCK_ACCOUNT', $subject));
        self::assertEquals(true, $this->callProtectedMethod($userVoter, 'supports', 'UNLOCK_ACCOUNT', $subject));
        self::assertEquals(false, $this->callProtectedMethod($userVoter, 'supports', 'UNLOCK_ACCOUNT', false));
        self::assertEquals(false, $this->callProtectedMethod($userVoter, 'supports', 'unsupported', $subject));
    }

    private function callProtectedMethod(object $object, string $method, mixed...$args): mixed
    {
        try {
            $reflectionMethod = new \ReflectionMethod($object, $method);
        } catch (\ReflectionException $exception) {
            self::fail($exception->getMessage());
        }

        $reflectionMethod->setAccessible(true);

        try {
            return $reflectionMethod->invoke($object, ...$args);
        } catch (\ReflectionException $exception) {
            self::fail($exception->getMessage());
        }
    }
}
