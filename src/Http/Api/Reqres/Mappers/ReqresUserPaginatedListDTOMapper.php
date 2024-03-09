<?php

namespace Domain\Http\Api\Reqres\Mappers;

use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Http\Api\Reqres\Validators\ReqresGetUsersPaginatedValidator;
use Domain\Models\UserPaginatedListDTO;

class ReqresUserPaginatedListDTOMapper
{

    /**
     * @param array<string, mixed> $responseData
     * @return UserPaginatedListDTO
     */
    static public function createFromResponse(array $responseData): UserPaginatedListDTO
    {
        $list = [];
        foreach ($responseData['data'] as $userDTO) {
            $list[] = ReqresGetUserByIdToUserDTOMapper::createFromResponse($userDTO);
        }
        return new UserPaginatedListDTO(
            intval($responseData['page']),
            intval($responseData['per_page']),
            intval($responseData['total']),
            intval($responseData['total_pages']),
            $list
        );
    }
}