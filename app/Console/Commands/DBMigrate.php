<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DBMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute all migrations and seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Dropping all tables...");
        $this->call("db:wipe");
        $this->info("Executing migrations");
        $this->call("migrate");
        $this->info("Seeding the database");
        //save.php
        $this->call("db:seed");
        // $this->fail('Ouch! That hurt! Please don\'t do that again :(');
    }
}
