<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'rep',
            ],
            [
                'name' => 'user',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role
            ]);
        }
    }
}
