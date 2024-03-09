<?php

namespace Domain\Tests\E2E;

use Domain\Services\UserService;
use Domain\Tests\DomainBaseTestCase;
use Psr\Log\LoggerInterface;

class UserServiceTest extends DomainBaseTestCase
{
    public function test_it_can_get_user_by_id(): void
    {
        $service = new UserService();
        $user = $service->getUserById(1);

        $this->assertNotNull($user);
        $this->assertEquals(1, $user->id);
    }

    public function test_get_user_by_id_returns_null_when_user_not_found(): void
    {
        $service = new UserService();
        $user = $service->getUserById(-1);
        $this->assertNull($user);
    }

    public function test_it_can_get_user_paginated_list(): void
    {
        $service = new UserService();
        $userPaginatedList = $service->getUsersPaginated(1);

        $this->assertEquals(1, $userPaginatedList->page);
        $this->assertCount(6, $userPaginatedList->list);
    }

    public function test_it_can_create_user(): void
    {
        $service = new UserService();
        $userId = $service->createUser('Foo', 'Bar');

        $this->assertNotNull($userId);
    }

    public function test_get_user_by_id_will_create_logs(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->atLeastOnce())->method('log');

        $service = new UserService($logger);
        $user = $service->getUserById(1);
    }
}