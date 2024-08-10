<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        $data = array(
            array('id' => '1', 'title' => 'تهران', 'province_id' => '1', 'created_at' => '2024-08-05 19:44:37', 'updated_at' => '2024-08-05 19:44:37'),
        );
        foreach ($data as $item) {
            \App\Models\City::create($item);
        }
    }
}
