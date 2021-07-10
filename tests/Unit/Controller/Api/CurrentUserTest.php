<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\Api;

use App\Controller\Api\User\CurrentUser;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

/**
 * @covers \App\Controller\Api\User\CurrentUser
 */
final class CurrentUserTest extends TestCase
{
    /**
     * @testdox Method __invoke() returns the user.
     */
    public function testInvokeReturnUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $security = $this
            ->getMockBuilder(Security::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getUser'])
            ->getMock();

        $security
            ->method('getUser')
            ->will(self::returnValue($user));

        $request = $this
            ->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $currentUser = new CurrentUser($security);
        
        self::assertEquals($user, $currentUser->__invoke($request));
    }
}
