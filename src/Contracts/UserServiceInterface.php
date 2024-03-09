<?php

namespace Domain\Contracts;

use Domain\Exceptions\HttpExceptionDomain;
use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Exceptions\NetworkException;
use Domain\Models\UserDTO;
use Domain\Models\UserPaginatedListDTO;
use Psr\Log\LoggerInterface;

interface UserServiceInterface
{
    /**
     * @param LoggerInterface|null $logger Logger used to logs all HTTP requests
     */
    public function __construct(?LoggerInterface $logger);

    /**
     * Retrieve a user from the user id
     *
     * @param int $id
     * @return UserDTO|null
     *
     * @throws UnexpectedApiResponseException
     * @throws HttpExceptionDomain
     * @throws NetworkException
     */
    public function getUserById(int $id): ?UserDTO;

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
    public function createUser(string $name, string $job): int;

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
    public function getUsersPaginated(int $page): UserPaginatedListDTO;
}