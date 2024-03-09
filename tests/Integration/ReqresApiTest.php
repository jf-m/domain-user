<?php

namespace Domain\Tests\Integration;

use Domain\Exceptions\HttpExceptionDomain;
use Domain\Exceptions\HttpNotFoundException;
use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Http\Api\Reqres\ReqresApi;
use Domain\Tests\DomainBaseTestCase;

class ReqresApiTest extends DomainBaseTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_it_can_get_user_by_id(): void
    {
        $api = new ReqresApi();
        $this->mockHttpClientWith(200, [
            'data' => [
                'id' => 1,
                'email' => 'jfmeinesz@gmail.com',
                'avatar' => 'avatar.jpg',
                'last_name' => 'Meinesz',
                'first_name' => 'Jeff',
            ]
        ]);

        $userId = 1;
        $user = $api->getUserById($userId);
        $this->assertEquals($user->id, $userId);
    }

    public function test_get_user_id_throws_exception_when_unexpected_response(): void
    {
        $api = new ReqresApi();
        $this->mockHttpClientWith(200, [
            'foo' => 'bar'
        ]);

        $this->expectException(UnexpectedApiResponseException::class);

        $api->getUserById(1);
    }

    public function test_get_user_id_throws_exception_when_incomplete_response(): void
    {
        $api = new ReqresApi();
        $this->mockHttpClientWith(200, [
            'data' => [
                //'id' => 1,
                'email' => 'jfmeinesz@gmail.com',
                'avatar' => 'avatar.jpg',
                'last_name' => 'Meinesz',
                'first_name' => 'Jeff'
            ]
        ]);

        $this->expectException(UnexpectedApiResponseException::class);

        $api->getUserById(1);
    }

    public function test_get_user_id_throws_exception_when_http_error(): void
    {
        $api = new ReqresApi();
        $this->mockHttpClientWith(422);

        $this->expectException(HttpExceptionDomain::class);
        $this->expectExceptionCode(422);

        $api->getUserById(1);
    }

    public function test_get_user_id_throws_custom_exception_when_404_http_error(): void
    {
        $api = new ReqresApi();
        $this->mockHttpClientWith(404);

        $this->expectException(HttpNotFoundException::class);
        $this->expectExceptionCode(404);

        $api->getUserById(1);
    }

    public function test_create_user_do_create_user(): void
    {
        $api = new ReqresApi();
        $userId = 680;
        $this->mockHttpClientWith(200, [
            "name" => "morpheus",
            "job" => "leader",
            "id" => $userId,
            "createdAt" => "2024-03-09T12:22:31.123Z"
        ]);

        $createdUserId = $api->createUser('Foo', 'Bar');
        $this->assertEquals($userId, $createdUserId);
    }

    public function test_create_user_throws_exception_on_invalid_response(): void
    {
        $api = new ReqresApi();
        $this->mockHttpClientWith(200, [
            "foo" => "bar",
        ]);
        $this->expectException(UnexpectedApiResponseException::class);
        $api->createUser('', '');
        $this->mockHttpClientWith(200, [
            "id" => "bar",
        ]);
        $this->expectException(UnexpectedApiResponseException::class);
        $api->createUser('', '');
    }

    public function test_get_user_paginated_successful(): void
    {
        $api = new ReqresApi();
        $this->mockHttpClientWith(200, [
            "page" => 2,
            "per_page" => 6,
            "total" => 12,
            "total_pages" => 2,
            "data" => [
                [
                    'id' => 1,
                    'email' => 'jfmeinesz@gmail.com',
                    'avatar' => 'avatar.jpg',
                    'last_name' => 'Meinesz',
                    'first_name' => 'Jeff']
            ]
        ]);

        $paginatedList = $api->getUsersPaginated(1);
        $this->assertEquals(2, $paginatedList->page);
        $this->assertCount(1, $paginatedList->list);
    }

    public function test_get_user_throws_exception_on_invalid_response(): void
    {
        $api = new ReqresApi();
        $this->mockHttpClientWith(200, [
            "page" => 2,
            "per_page" => 6,
            "total" => 12,
            "total_pages" => 2
        ]);

        $this->expectException(UnexpectedApiResponseException::class);
        $api->getUsersPaginated(1);
    }
}
