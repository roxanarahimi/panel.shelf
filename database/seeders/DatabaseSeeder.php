<?php

namespace Database\Seeders;

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

        $this->seed([
//            UserSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            RegionSeeder::class,
            CustomerSeeder::class,
            SectorSeeder::class,
            SkuSeeder::class,
        ]);
    }
}
