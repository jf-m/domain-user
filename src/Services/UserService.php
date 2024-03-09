<?php

namespace Domain\Services;


use Domain\Contracts\UserServiceInterface;
use Domain\Exceptions\HttpNotFoundException;
use Domain\Http\Api\Api;
use Domain\Http\Api\Reqres\ReqresApi;
use Domain\Http\GuzzleClientSingleton;
use Domain\Models\UserDTO;
use Domain\Models\UserPaginatedListDTO;
use Psr\Log\LoggerInterface;

class UserService implements UserServiceInterface
{
    private Api $api;

    /**
     * {@inheritDoc}
     */
    public function __construct(?LoggerInterface $logger = null)
    {
        if ($logger) {
            GuzzleClientSingleton::setClientWithLoggerInterface($logger);
        }
        $this->api = new ReqresApi();
    }

    /**
     * {@inheritDoc}
     */
    public function getUserById(int $id): ?UserDTO
    {
        try {
            return $this->api->getUserById($id);
        } catch (HttpNotFoundException $exception) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function createUser(string $name, string $job): int
    {
        return $this->api->createUser($name, $job);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsersPaginated(int $page): UserPaginatedListDTO
    {
        return $this->api->getUsersPaginated($page);
    }
}