<?php

namespace Domain\Http;

use Domain\Exceptions\HttpExceptionDomain;
use Domain\Exceptions\HttpNotFoundException;
use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Exceptions\NetworkException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    public function __construct(
        private readonly string $baseUri
    )
    {
    }


    /**
     * Send an HTTP Request
     *
     * @param string $method HTTP Method (get, put, post...)
     * @param string $uri
     * @param array<string, mixed> $queryParameters
     * @param array<string, mixed> $requestBody Body of the request (POST, PUT...)
     *
     * @return array<string, mixed>|null Returns the json response as an associative array.
     *
     * @throws UnexpectedApiResponseException
     * @throws HttpExceptionDomain
     */
    public function request(string $method, string $uri, array $queryParameters = [], array $requestBody = []): ?array
    {
        $options = [];
        if ($queryParameters) {
            $options['query'] = $queryParameters;
        }
        if ($requestBody) {
            $options['body'] = json_encode($requestBody);
        }
        try {
            $response = GuzzleClientSingleton::getClient()->request($method, sprintf('%s/%s', $this->baseUri, $uri), $options);
        } catch (ConnectException|TooManyRedirectsException $exception) {
            throw new NetworkException($exception->getMessage(), $exception->getCode(), $exception);
        } catch (GuzzleException $exception) {
            throw match ($exception->getCode()) {
                404 => new HttpNotFoundException($exception->getMessage(), $exception->getCode(), $exception),
                default => new HttpExceptionDomain($exception->getMessage(), $exception->getCode(), $exception),
            };
        }

        return $this->formatResponseToJson($response);
    }

    /**
     * Decode the response body to an associative array
     *
     * @param ResponseInterface $response
     * @return array<string, mixed>|null
     *
     * @throws UnexpectedApiResponseException
     */
    private function formatResponseToJson(ResponseInterface $response): ?array
    {
        $contents = $response->getBody()->getContents();

        try {
            $jsonData = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
            if (empty($jsonData)) {
                return null;
            }
            return $jsonData;
        } catch (\JsonException $exception) {
            throw new UnexpectedApiResponseException($contents);
        }
    }

}