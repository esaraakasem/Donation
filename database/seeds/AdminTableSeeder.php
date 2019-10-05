<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'Admin',
        	'email' => 'admin@admin.com',
        	'password' => bcrypt('admin2468'),
        	'role' => 'admin',
        	'fcm_android' => 'haha'
        ]);
    }
}
