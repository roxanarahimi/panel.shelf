<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{

    public function run()
    {
        $data = array(
            array('id' => '1', 'title' => 'تهران', 'created_at' => '2024-08-05 19:44:37', 'updated_at' => '2024-08-05 19:44:37'),
        );
        foreach ($data as $item) {
            \App\Models\Province::create($item);
        }
    }
}
