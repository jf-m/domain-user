<?php

namespace Domain\Tests;

use Domain\Http\GuzzleClientSingleton;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

abstract class DomainBaseTestCase extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        GuzzleClientSingleton::tearDown();
        parent::tearDown();
    }

    /**
     * Helper function to quickly mock the HttpClient on the next request
     *
     * @param int $httpStatus Http status code to return with the response
     * @param array<string, mixed>|null $body Body to return as a response
     * @return void
     */
    protected function mockHttpClientWith(int $httpStatus, ?array $body = null): void
    {
        GuzzleClientSingleton::setClient(new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new Response($httpStatus, [], json_encode($body) ?: null),
            ]))
        ]));
    }
}