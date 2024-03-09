<?php

namespace Domain\Exceptions;

/**
 * Exception occuring when sending an HTTP Request
 *
 * The distant server may or may not have responded a http status code.
 */
class HttpExceptionDomain extends DomainBaseException
{
}