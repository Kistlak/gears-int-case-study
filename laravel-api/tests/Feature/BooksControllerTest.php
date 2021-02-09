<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use App\Models\StatusAuthor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksControllerTest extends TestCase
{
    public function test_can_list_books()
    {
        $user = User::factory()->create();
        $books = Book::factory(2)->create([
            'user_id' => $user->id,
            'book_name' => 'New Name',
            'description' => 'Book des',
            'price' => 250
        ]);

        $response = $this->actingAs($user, 'api')->get('api/books')->assertStatus(200);

//        $response->assertStatus(200)
//            ->assertJsonStructure([
//                'data'=> [
//                    '*' => [
//                        'user_id',
//                        'book_name',
//                        'description',
//                        'price'
//                    ]
//                ]
//            ]);
    }

    public function test_can_create_book()
    {
        // arrange
        $user = User::factory()->create();
        $data = [
            'book_name' => 'Mark Twain',
            'description' => 'Book des',
            'price' => 250
        ];

        // acting
        $response = $this->actingAs($user, 'api')->postJson('api/books', $data);

        // assert
        $response->assertStatus(201);
        $data['user_id'] = $user->id;
        $this->assertDatabaseHas('books', $data);
    }

    public function test_can_update_books()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'user_id' => $user->id
        ]);
        $data = [
            'book_name' => 'Mark Twain',
            'description' => 'Book des',
            'price' => 250
        ];

        $response = $this->actingAs($user, 'api')->put('api/books/'.$book->id, $data);

        $response->assertStatus(200);
        $data['id'] = $book->id;
        $data['user_id'] = $user->id;
        $this->assertDatabaseHas('books', $data);
    }

    public function test_can_delete_books()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user, 'api')->delete('api/books/'.$book->id);

        $response->assertStatus(204);
        $this->assertDeleted($book);
    }

    public function test_only_author_can_delete_a_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user, 'api')->delete('api/books/'.$book->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('books', $book->toArray());
    }

    public function test_admin_can_delete_a_book()
    {
        $user = User::factory()->create()->assignRole(User::ROLE_ADMIN);
        $book = Book::factory()->create();

        $response = $this->actingAs($user, 'api')->delete('api/books/'.$book->id);

        $response->assertStatus(204);
        $this->assertDeleted($book);
    }
}
