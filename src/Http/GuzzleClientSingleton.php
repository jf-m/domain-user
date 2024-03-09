<?php

namespace Domain\Http;

use Domain\Http\Middlewares\GuzzleExceptionHandlerMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;

class GuzzleClientSingleton
{
    public static Client|null $client = null;

    public static function getClient(): Client
    {
        if (self::$client === null) {
            self::$client = new Client([]);
        }
        return self::$client;
    }

    /**
     * Store in this singleton a guzzle client using the specified LoggerInterface
     *
     * @param LoggerInterface $logger
     * @return void
     */
    public static function setClientWithLoggerInterface(LoggerInterface $logger): void
    {
        if (self::$client === null) {
            $stack = HandlerStack::create();
            $stack->push(Middleware::log($logger, new MessageFormatter()));

            $client = new Client([
                'handler' => $stack
            ]);
            self::setClient($client);
        }
    }

    public static function setClient(?Client $client): void
    {
        self::$client = $client;
    }

    public static function tearDown(): void
    {
        self::$client = null;
    }
}