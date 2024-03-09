<?php

namespace Domain\Tests\Unit\Reqres;

use Domain\Http\Api\Reqres\Mappers\ReqresUserPaginatedListDTOMapper;
use Domain\Models\UserPaginatedListDTO;
use Domain\Tests\DomainBaseTestCase;

class ReqresUserPaginatedListDTOMapperTest extends DomainBaseTestCase
{

    public function test_it_can_create_user_paginated_list_DTO_from_reqres(): void
    {
        $user = ReqresUserPaginatedListDTOMapper::createFromResponse([
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
        $this->assertInstanceOf(UserPaginatedListDTO::class, $user);
    }
}
