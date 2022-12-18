<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::first()->get();
//
        User::create([
           'name' => 'Adam',
           'email' => 'adam@admin.com',
           'password' => bcrypt('123456'),
            'role_id' => Role::all()->random()->id
        ]);
//        User::factory(10)->create();

    }

}
