<?php

namespace Database\Seeders;

use App\Models\role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->create([
            array(
                "id" => 99,
                "roleName" => "admin"
            ),
            array(
                "id" => 1,
                "roleName" => "member"
            ),
            array(
                "id" => 2,
                "roleName" => "guest"
            )
        ]);
        \App\Models\User::factory(1)->create();
    }
}
