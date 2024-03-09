<?php

namespace Domain\Tests\Unit\Reqres;

use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Http\Api\Reqres\Validators\ReqresCreateUserValidator;
use Domain\Tests\DomainBaseTestCase;

class ReqresCreateUserValidatorTest extends DomainBaseTestCase
{
    public function test_it_can_validate_valid_answer_from_reqres(): void
    {
        $this->expectNotToPerformAssertions();
        ReqresCreateUserValidator::validateFromResponse([
            "name" => "morpheus",
            "job" => "leader",
            "id" => "130",
            "createdAt" => "2024-03-09T12:22:31.123Z"
        ]);
    }

    public function test_it_can_throw_exception_when_missing_id_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresCreateUserValidator::validateFromResponse([
            "name" => "morpheus",
            "job" => "leader",
            "createdAt" => "2024-03-09T12:22:31.123Z"
        ]);
    }

    public function test_it_can_throw_exception_when_no_data_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresCreateUserValidator::validateFromResponse(null);
    }

    public function test_it_can_throw_exception_when_not_int_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresCreateUserValidator::validateFromResponse([
            "name" => "morpheus",
            "job" => "leader",
            "id" => "not-int",
            "createdAt" => "2024-03-09T12:22:31.123Z"
        ]);
    }
}
