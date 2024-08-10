<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            array('id' => '1','city_id' => '1','title' => '1','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '2','city_id' => '1','title' => '2','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '3','city_id' => '1','title' => '3','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '4','city_id' => '1','title' => '4','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '5','city_id' => '1','title' => '5','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '6','city_id' => '1','title' => '6','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '7','city_id' => '1','title' => '7','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '8','city_id' => '1','title' => '8','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '9','city_id' => '1','title' => '9','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '10','city_id' => '1','title' => '10','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '11','city_id' => '1','title' => '11','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '12','city_id' => '1','title' => '12','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '13','city_id' => '1','title' => '13','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '14','city_id' => '1','title' => '14','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '15','city_id' => '1','title' => '15','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '16','city_id' => '1','title' => '16','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '17','city_id' => '1','title' => '17','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '18','city_id' => '1','title' => '18','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '19','city_id' => '1','title' => '19','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '20','city_id' => '1','title' => '20','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '21','city_id' => '1','title' => '21','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
            array('id' => '22','city_id' => '1','title' => '22','active' => '0','created_at' => '2024-08-05 19:44:37','updated_at' => '2024-08-05 19:44:37'),
        );
        foreach ($data as $item) {
            \App\Models\Region::create($item);
        }
    }
}
