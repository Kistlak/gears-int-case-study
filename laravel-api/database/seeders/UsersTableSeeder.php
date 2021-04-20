<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\StatusAuthor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
        ->each(function (User $user) {
//            $user->role()->save(Role::factory(Role::class)->make());
            $user->assignRole(User::ROLE_AUTHOR);
            $user->book()->save(Book::factory(Book::class)->make());
            $user->status()->save(StatusAuthor::factory(StatusAuthor::class)->make());
        });
    }
}
