<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Moment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'class' => 'SD2A'
            // 'password' => bcrypt('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@example.com',
            'class' => 'SD2A'
        ]);
        // User::factory(10)->create();

        User::find(1)->addRole('administrator');
        User::find(2)->addRole('user');

        Moment::insert(['time' => '13:00 - 13:45']);
        Moment::insert(['time' => '13:45 - 14:30']);
        Moment::insert(['time' => '15:00 - 15:45']);
    } 
}
