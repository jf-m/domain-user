<?php

namespace Domain\Tests\Unit\Reqres;

use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Http\Api\Reqres\Validators\ReqresGetUsersPaginatedValidator;
use Domain\Tests\DomainBaseTestCase;

class ReqresGetUsersPaginatedValidatorTest extends DomainBaseTestCase
{
    public function test_it_can_validate_valid_answer_from_reqres(): void
    {
        $this->expectNotToPerformAssertions();
        ReqresGetUsersPaginatedValidator::validateFromResponse([
            "page" => 2,
            "per_page" => 6,
            "total" => 12,
            "total_pages" => 2,
            "data" => [
                [
                    'id' => 1,
                    'email' => 'jfmeinesz@gmail.com',
                    'avatar' => 'avatar.jpg',
                    'last_name' => 'Meinesz',
                    'first_name' => 'Jeff']
            ]
        ]);
    }

    public function test_it_can_throw_exception_when_missing_data_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresGetUsersPaginatedValidator::validateFromResponse([
            "page" => 2,
            "per_page" => 6,
            "total" => 12,
            "total_pages" => 2
        ]);
    }

    public function test_it_can_throw_exception_when_no_data_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresGetUsersPaginatedValidator::validateFromResponse(null);
    }

    public function test_it_can_throw_exception_when_not_int_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresGetUsersPaginatedValidator::validateFromResponse([
            "page" => "page2",
            "per_page" => 6,
            "total" => 12,
            "total_pages" => 2,
            "data" => [
                [
                    'id' => 1,
                    'email' => 'jfmeinesz@gmail.com',
                    'avatar' => 'avatar.jpg',
                    'last_name' => 'Meinesz',
                    'first_name' => 'Jeff']
            ]
        ]);
    }
}
