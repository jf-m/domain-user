<?php

namespace Domain\Tests\Unit;

use Domain\Models\UserDTO;
use Domain\Models\UserPaginatedListDTO;
use Domain\Tests\DomainBaseTestCase;

class UserPaginatedListDTOTest extends DomainBaseTestCase
{
    public function test_it_can_be_json_serialized(): void
    {
        $paginatedListDTO = new UserPaginatedListDTO(
            1,
            6,
            12,
            2,
            [
                new UserDTO(
                    1,
                    'jfmeinesz@gmail.com',
                    'jeff',
                    'meinesz',
                    'avatar.jpg'
                )
            ]
        );
        $this->assertEquals(json_encode($paginatedListDTO), '{"page":1,"per_page":6,"total":12,"total_pages":2,"list":[{"id":1,"email":"jfmeinesz@gmail.com","first_name":"jeff","last_name":"meinesz","avatar":"avatar.jpg"}]}');
    }
}
