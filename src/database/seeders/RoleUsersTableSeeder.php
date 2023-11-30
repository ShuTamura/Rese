<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_users[] = [
                'user_id' => 1,
                'role_id' => 1,
            ];
        for($i=2;$i<=10;$i++) {
            $role_users[] = [
                'user_id' => $i,
                'role_id' => 3,
            ];
        }

        foreach ($role_users as $role_user) {
            DB::table('role_users')->insert([
                'user_id' => $role_user['user_id'],
                'role_id' => $role_user['role_id'],
            ]);
        }
    }
}
