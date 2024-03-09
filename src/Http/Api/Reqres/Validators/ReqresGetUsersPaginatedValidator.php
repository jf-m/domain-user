<?php

namespace Domain\Http\Api\Reqres\Validators;

use Domain\Exceptions\UnexpectedApiResponseException;

class ReqresGetUsersPaginatedValidator
{
    /**
     * @param array<string,mixed>|null $responseData
     * @return array<string,mixed>
     * @throws UnexpectedApiResponseException
     */
    static public function validateFromResponse(?array $responseData): array
    {
        if (!$responseData ||
            !is_int($responseData['page'] ?? null) ||
            !is_int($responseData['per_page'] ?? null) ||
            !is_int($responseData['total'] ?? null) ||
            !is_int($responseData['total_pages'] ?? null) ||
            !is_array($responseData['data'] ?? null)
        ) {
            throw new UnexpectedApiResponseException($responseData);
        }
        foreach ($responseData['data'] as $userDto) {
            ReqresGetUserByIDValidator::validateFromResponse($userDto);
        }

        return $responseData;
    }
}