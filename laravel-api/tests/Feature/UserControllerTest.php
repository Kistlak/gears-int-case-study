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

    public function test_can_create_users()
    { //ask this one
        $user = [
            'first_name' => 'Kistlak',
            'last_name' => 'User',
            'slug' => 'kistlak-user',
            'email' => 'ka@g.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'khgytre123',
        ];

        $response = $this->postJson('api/users', $user);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $user);
    }
}
