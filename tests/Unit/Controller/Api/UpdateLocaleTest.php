<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\Api;

use App\Controller\Api\User\UpdateLocale;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Controller\Api\User\UpdateLocale
 */
final class UpdateLocaleTest extends TestCase
{
    /**
     * @testdox Method __invoke() returns the user.
     */
    public function testInvokeReturnUser(): void
    {
        $user = $this
            ->getMockBuilder(User::class)
            ->getMock();

        $updateLocale = new UpdateLocale();
        
        self::assertEquals($user, $updateLocale->__invoke($user));
    }
}
