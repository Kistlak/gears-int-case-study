<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->insert([
            ['name' => User::ROLE_ADMIN,'guard_name' => 'api'],
            ['name' => User::ROLE_AUTHOR, 'guard_name' => 'api']
        ]);
    }
}
