<?php

namespace Domain\Http\Api\Reqres\Validators;

use Domain\Exceptions\UnexpectedApiResponseException;

class ReqresCreateUserValidator
{
    /**
     * @param array<string,mixed>|null $responseData
     * @return array<string,mixed>
     * @throws UnexpectedApiResponseException
     */
    static public function validateFromResponse(?array $responseData): array
    {
        if (!$responseData ||
            intval($responseData['id'] ?? null) == null ||
            intval($responseData['id']) != $responseData['id']
        ) {
            throw new UnexpectedApiResponseException($responseData);
        }
        return $responseData;
    }
}