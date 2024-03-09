<?php

namespace Domain\Exceptions;

/**
 * Exception occuring when the response from the distant API is invalid or can't be parsed
 */
class UnexpectedApiResponseException extends DomainBaseException
{
    public function __construct(public mixed $responseData)
    {
        parent::__construct(
            message: sprintf('Invalid response data: %s', json_encode($this->responseData))
        );
    }

}