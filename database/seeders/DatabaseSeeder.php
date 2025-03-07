<?php

namespace Database\Seeders;

use App\Models\Bookings;
use App\Models\User;
use App\Models\Moment;
use App\Models\WorkshopMoment;
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
        User::insert([
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

        Moment::insert(['id' => '1', 'time' => '13:00 - 13:45']);
        Moment::insert(['id' => '2', 'time' => '13:45 - 14:30']);
        Moment::insert(['id' => '3', 'time' => '15:00 - 15:45']);

        WorkshopMoment::insert([
            'moment_id' => '1',
            'workshop_id' => '1',
        ]);

        WorkshopMoment::insert([
            'moment_id' => '2',
            'workshop_id' => '8',
        ]);

        WorkshopMoment::insert([
            'moment_id' => '3',
            'workshop_id' => '3',
        ]);

        Bookings::insert([
            'wm_id' => '1',
            'student_id' => '1',
        ]);

        Bookings::insert([
            'wm_id' => '2',
            'student_id' => '1',
        ]);

        Bookings::insert([
            'wm_id' => '3',
            'student_id' => '1',
        ]);
    } 
}
