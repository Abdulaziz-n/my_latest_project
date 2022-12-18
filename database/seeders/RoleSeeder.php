<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
           'name' => 'Admin test',
           'permission' => [
               'dashboard' => [
                   'edit' => 'true',
                   'create' => 'true',
                   'view' => 'true',
                   'delete' => 'true'
               ]
           ]
        ]);
    }
}
