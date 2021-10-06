<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\StatusAuthor;

class UserControllerTest extends TestCase
{
    public function test_only_admin_can_list_users()
    {
        $user = User::factory()->create()->assignRole(User::ROLE_ADMIN);

        $response = $this->actingAs($user, 'api')->get('api/users');

//        $response->assertStatus(200);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'=> [
                    '*' => [
                        'first_name',
                        'last_name',
                        'slug',
                        'email'
                    ]
                ]
            ]);
    }

    public function test_others_cant_list_users()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get('api/users');

        $response->assertStatus(403);
    }

}
