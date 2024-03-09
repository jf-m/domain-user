<?php

namespace Domain\Tests\Unit\Reqres;

use Domain\Http\Api\Reqres\Mappers\ReqresGetUserByIdToUserDTOMapper;
use Domain\Models\UserDTO;
use Domain\Tests\DomainBaseTestCase;

class ReqresGetUserByIdToUserDTOMapperTest extends DomainBaseTestCase
{

    public function test_it_can_create_userDTO_from_reqres(): void
    {
        $user = ReqresGetUserByIdToUserDTOMapper::createFromResponse([
            'id' => 'not-int',
            'email' => 'jfmeinesz@gmail.com',
            'first_name' => 'Jeff',
            'last_name' => 'Meinesz',
            'avatar' => 'avatar.jpg'
        ]);
        $this->assertInstanceOf(UserDTO::class, $user);
    }
}
