<?php

namespace Domain\Tests\Unit\Reqres;

use Domain\Exceptions\UnexpectedApiResponseException;
use Domain\Http\Api\Reqres\Validators\ReqresGetUserByIDValidator;
use Domain\Tests\DomainBaseTestCase;

class ReqresGetUserByIdValidatorTest extends DomainBaseTestCase
{
    public function test_it_can_validate_valid_answer_from_reqres(): void
    {
        $this->expectNotToPerformAssertions();
        ReqresGetUserByIDValidator::validateFromResponse([
            'id' => 1,
            'email' => 'jfmeinesz@gmail.com',
            'first_name' => 'Jeff',
            'last_name' => 'Meinesz',
            'avatar' => 'avatar.jpg'
        ]);
    }

    public function test_it_can_throw_exception_when_missing_data_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresGetUserByIDValidator::validateFromResponse([
            'id' => 1,
            'first_name' => 'Jeff',
            'last_name' => 'Meinesz',
            'avatar' => 'avatar.jpg'
        ]);
    }

    public function test_it_can_throw_exception_when_no_data_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresGetUserByIDValidator::validateFromResponse(null);
    }

    public function test_it_can_throw_exception_when_id_not_int_from_reqres(): void
    {
        $this->expectException(UnexpectedApiResponseException::class);
        ReqresGetUserByIDValidator::validateFromResponse([
            'id' => 'not-int',
            'email' => 'jfmeinesz@gmail.com',
            'first_name' => 'Jeff',
            'last_name' => 'Meinesz',
            'avatar' => 'avatar.jpg'
        ]);
    }
}
