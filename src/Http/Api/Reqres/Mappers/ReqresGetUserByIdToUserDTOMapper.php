<?php

namespace Domain\Http\Api\Reqres\Mappers;

use Domain\Models\UserDTO;

class ReqresGetUserByIdToUserDTOMapper
{
    /**
     * @param array<string, mixed> $responseData
     * @return UserDTO
     */
    static public function createFromResponse(array $responseData): UserDTO
    {
        return new UserDTO(
            intval($responseData['id']),
            $responseData['email'],
            $responseData['first_name'],
            $responseData['last_name'],
            $responseData['avatar']
        );
    }
}