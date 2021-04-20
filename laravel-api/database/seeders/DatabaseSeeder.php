<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
//         \App\Models\User::factory(5)->create();
        $this->call(RoleSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
