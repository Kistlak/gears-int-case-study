<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Role;
use App\Models\StatusAuthor;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(5)->create()
        ->each(function ($user) {
            $user->role()->save(Role::factory(Role::class)->make());
            $user->book()->save(Book::factory(Book::class)->make());
            $user->status()->save(StatusAuthor::factory(StatusAuthor::class)->make());
        });
    }
}
