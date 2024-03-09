<?php

namespace Domain\Tests\Unit;

use Domain\Models\UserDTO;
use Domain\Tests\DomainBaseTestCase;

class UserDTOTest extends DomainBaseTestCase
{

    public function test_it_can_be_json_serialized(): void
    {
        $user = new UserDTO(
            1,
            'jfmeinesz@gmail.com',
            'jeff',
            'meinesz',
            'avatar.jpg'
        );
        $this->assertEquals(json_encode($user), '{"id":1,"email":"jfmeinesz@gmail.com","first_name":"jeff","last_name":"meinesz","avatar":"avatar.jpg"}');
    }

    public function test_it_can_be_parsed_as_array(): void
    {
        $user = new UserDTO(
            1,
            'jfmeinesz@gmail.com',
            'jeff',
            'meinesz',
            'avatar.jpg'
        );
        $asArray = (array)$user;
        $this->assertEquals($asArray, [
            "id" => 1,
            "email" => "jfmeinesz@gmail.com",
            "firstName" => "jeff",
            "lastName" => "meinesz",
            "avatar" => "avatar.jpg"]);
    }
}
