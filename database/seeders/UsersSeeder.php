<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->merchant()->create([
            "email"    =>  "merchant@email.com"
        ]);
        User::factory(1)->create([
            "email"    =>  "customer@email.com"
        ]);
    }
}
