<?php

namespace Domain\Http\Api\Reqres;


use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Http\Api\Api;
use Domain\Http\Api\Reqres\Mappers\ReqresGetUserByIdToUserDTOMapper;
use Domain\Http\Api\Reqres\Mappers\ReqresUserPaginatedListDTOMapper;
use Domain\Http\Api\Reqres\Validators\ReqresCreateUserValidator;
use Domain\Http\Api\Reqres\Validators\ReqresGetUserByIDValidator;
use Domain\Http\Api\Reqres\Validators\ReqresGetUsersPaginatedValidator;
use Domain\Models\UserDTO;
use Domain\Models\UserPaginatedListDTO;

class ReqresApi extends Api
{

    /**
     * {@inheritDoc}
     */
    protected function getBaseUri(): string
    {
        return 'https://reqres.in/api';
    }

    /**
     * {@inheritDoc}
     */
    public function getUserById(int $id): UserDTO
    {
        $responseData = $this->httpClient->request('get', sprintf('users/%d', $id));
        $responseData = ReqresGetUserByIDValidator::validateFromResponse($responseData['data'] ?? null);
        return ReqresGetUserByIdToUserDTOMapper::createFromResponse($responseData);
    }

    /**
     * {@inheritDoc}
     */
    public function createUser(string $name, string $job): int
    {
        $responseBody = $this->httpClient->request('post', 'users', requestBody: [
            'name' => $name,
            'job' => $job
        ]);
        $responseBody = ReqresCreateUserValidator::validateFromResponse($responseBody);

        return $responseBody['id'];
    }

    /**
     * {@inheritDoc}
     */
    public function getUsersPaginated(int $page): UserPaginatedListDTO
    {
        $users = $this->httpClient->request('get', 'users', [
            'page' => $page
        ]);
        $users = ReqresGetUsersPaginatedValidator::validateFromResponse($users);
        return ReqresUserPaginatedListDTOMapper::createFromResponse($users);
    }
}