<?php

use Illuminate\Database\Seeder;

class create_admin_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'telegram_id' => '12345678910'
        ]);
    }
}
