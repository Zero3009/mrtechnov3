<?php

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
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'mramire7',
            'email' => 'matiasgr97@Outlook.com',
            'password' => bcrypt('cil123'),
        ]);
    }
}
