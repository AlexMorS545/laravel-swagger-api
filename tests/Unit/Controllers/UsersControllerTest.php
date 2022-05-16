<?php

namespace Tests\Unit\Controllers;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    public function test_get_users_json()
    {
        $response = $this->getJson('/api/users');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]
            );
    }

    public function test_get_one_user_json()
    {
        $response = $this->getJson('/api/users/2');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                ->first(fn ($json) =>
                $json->where('id', 2)
                    ->etc()
                )
            );

    }
}
