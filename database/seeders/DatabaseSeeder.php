<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\KecamatanTableSeeder;
use Database\Seeders\KelurahanTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\PuskesmasTableSeeder;
use Database\Seeders\PosyanduTableSeeder;
use Database\Seeders\RtTableSeeder;
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
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        // $this->call(KecamatanTableSeeder::class);
        // $this->call(KelurahanTableSeeder::class);
        // $this->call(PuskesmasTableSeeder::class);
        // $this->call(PosyanduTableSeeder::class);
        // $this->call(RtTableSeeder::class);
        $this->call(JenisTabelSeeder::class);
        
    }
}
