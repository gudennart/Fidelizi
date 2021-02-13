<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Client;
use App\Models\stores;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        stores::factory()
        ->count(10)
        ->create();

        Client::factory()
        ->count(10)
        ->create();
        
        Admin::factory()
        ->count(10)
        ->create();
    }
}
