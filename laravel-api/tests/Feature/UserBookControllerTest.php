<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class UserBookControllerTest extends TestCase
{
    public function test_can_search_user_books()
    {
        $user = User::factory()->create();
        $books = Book::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('api/users/'.$books->id.'/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
            'data'=> []
        ]);;
    }
}
