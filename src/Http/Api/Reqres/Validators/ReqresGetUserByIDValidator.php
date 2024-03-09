<?php

namespace Domain\Http\Api\Reqres\Validators;

use Domain\Exceptions\UnexpectedApiResponseException;

class ReqresGetUserByIDValidator
{
    /**
     * @param array<string,mixed>|null $responseData
     * @return array<string,mixed>
     * @throws UnexpectedApiResponseException
     */
    static public function validateFromResponse(?array $responseData): array
    {
        if (!$responseData ||
            !is_int($responseData['id'] ?? null) ||
            !is_string($responseData['email'] ?? null) ||
            !is_string($responseData['first_name'] ?? null) ||
            !is_string($responseData['last_name'] ?? null) ||
            !is_string($responseData['avatar'] ?? null)
        ) {
            throw new UnexpectedApiResponseException($responseData);
        }
        return $responseData;
    }
}