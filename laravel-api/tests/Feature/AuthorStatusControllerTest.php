<?php

namespace Tests\Feature;

use App\Models\StatusAuthor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class AuthorStatusControllerTest extends TestCase
{
    public function test_only_admin_can_change_user_status()
    {
        $user = User::factory()->create()->assignRole(User::ROLE_ADMIN);
        $status = StatusAuthor::factory()->create([
            'user_id' => $user->id,
            'status' => '0'
        ]);
        $data = [
            'status' => '1'
        ];

        $response = $this->actingAs($user, 'api')->put('api/users/'.$user->id.'/status', $data);

        $response->assertStatus(200);
        $data['user_id'] = $user->id;
        $this->assertDatabaseHas('status_authors', $data);
    }

    public function test_others_can_not_change_user_status()
    {
        $user = User::factory()->create();
        $status = StatusAuthor::factory()->create([
            'user_id' => $user->id,
            'status' => '0'
        ]);
        $data = [
            'status' => '1'
        ];

        $response = $this->actingAs($user, 'api')->put('api/users/'.$user->id.'/status', $data);

        $response->assertStatus(403);
    }
}
