<?php

namespace Domain\Http\Api;

use Domain\Exceptions\HttpExceptionDomain;
use Domain\Exceptions\HttpNotFoundException;
use Domain\Exceptions\NetworkException;
use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Http\HttpClient;
use Domain\Http\Middlewares\GuzzleExceptionHandlerMiddleware;
use Domain\Models\UserDTO;
use Domain\Models\UserPaginatedListDTO;

abstract class Api
{

    protected HttpClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpClient($this->getBaseUri());
    }

    /**
     * Returns the base URI of this API
     *
     * @return string
     */
    abstract protected function getBaseUri(): string;

    /**
     * Retrieve a user from the user id
     *
     * @param int $id
     * @return UserDTO
     *
     * @throws UnexpectedApiResponseException
     * @throws HttpExceptionDomain
     * @throws NetworkException
     * @throws HttpNotFoundException
     */
    abstract public function getUserById(int $id): UserDTO;

    /**
     * Creates a user
     *
     * @param string $name
     * @param string $job
     * @return int
     *
     * @throws UnexpectedApiResponseException
     * @throws HttpExceptionDomain
     * @throws NetworkException
     */
    abstract public function createUser(string $name, string $job): int;

    /**
     * Retrieve a paginated list of user
     *
     * @param int $page
     * @return UserPaginatedListDTO
     *
     * @throws UnexpectedApiResponseException
     * @throws HttpExceptionDomain
     * @throws NetworkException
     */
    abstract public function getUsersPaginated(int $page): UserPaginatedListDTO;
}