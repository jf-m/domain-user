<?php

namespace Domain\Tests\Unit;

use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Exceptions\NetworkException;
use Domain\Http\GuzzleClientSingleton;
use Domain\Http\HttpClient;
use Domain\Tests\DomainBaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class HttpClientTest extends DomainBaseTestCase
{

    private HttpClient $httpClient;
    private string $baseUri = 'dev.test';


    protected function setUp(): void
    {
        $this->httpClient = new HttpClient($this->baseUri);
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_it_format_response_to_json(): void
    {
        $this->mockHttpClientWith(200, ['foo' => 'bar']);
        $data = $this->httpClient->request('get', 'foo/bar');
        $this->assertEquals($data, ['foo' => 'bar']);
    }

    public function test_it_format_null_response(): void
    {
        $this->mockHttpClientWith(200, null);
        $data = $this->httpClient->request('get', 'foo/bar');
        $this->assertNull($data);
    }

    public function test_it_throws_exception_on_invalid_response_structure(): void
    {
        GuzzleClientSingleton::setClient(new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new Response(200, [], null),
            ]))
        ]));
        $this->expectException(UnexpectedApiResponseException::class);
        $data = $this->httpClient->request('get', 'foo/bar');
    }

    public function test_it_throws_exception_on_invalid_json_response(): void
    {
        GuzzleClientSingleton::setClient(new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new Response(200, [], '{data:not_valid_json;'),
            ]))
        ]));
        $this->expectException(UnexpectedApiResponseException::class);
        $data = $this->httpClient->request('get', 'foo/bar');
    }

    public function test_it_throws_exception_on_network_error(): void
    {
        GuzzleClientSingleton::setClient(new Client([
            'handler' => HandlerStack::create(new MockHandler([
                new ConnectException('Error Communicating with Server', new Request('GET', 'test')),
                new TooManyRedirectsException('Error Communicating with Server', new Request('GET', 'test')),
            ]))
        ]));
        $this->expectException(NetworkException::class);
        $this->httpClient->request('get', 'foo/bar');
        $this->expectException(NetworkException::class);
        $this->httpClient->request('get', 'foo/bar');
    }

    public function test_it_sends_correct_request_method_and_uri(): void
    {
        $container = [];
        $history = Middleware::history($container);
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode(['data' => '']) ?: null),
        ]));
        $handlerStack->push($history);
        GuzzleClientSingleton::setClient(new Client(['handler' => $handlerStack]));
        $postData = ['post' => 'data'];

        $data = $this->httpClient->request('put', 'foo/bar', ['qstring' => 'baz'], $postData);
        $this->assertEquals(1, count($container));
        $transaction = $container[0];
        /** @var Request $request */
        $request = $transaction['request'];

        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals(json_encode($postData), $request->getBody());
        $this->assertEquals(sprintf('%s/foo/bar?qstring=baz', $this->baseUri), $request->getUri());
    }
}
