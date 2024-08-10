<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            array('id' => '1', 'name' => 'رکسانا', 'email' => 'ms.roxanarahimi@gmail.com', 'mobile' => '09128222725', 'gender' => 'female', 'avatar' => NULL, 'email_verified_at' => NULL, 'password' => '$2y$10$nS5CsJ3c6e7496FbwAgyPu34Xc/QdbuN8YHciSgwej8TlgH.5J6my', 'scope' => 'admin', 'last_activity' => '2024-08-05 00:51:12', 'remember_token' => NULL, 'created_at' => '2021-12-30 14:33:40', 'updated_at' => '2024-08-04 22:51:12'),
            array('id' => '2', 'name' => 'واحد مارکتینگ', 'email' => 'marketing', 'mobile' => '', 'gender' => NULL, 'avatar' => NULL, 'email_verified_at' => NULL, 'password' => '$2y$10$8xVfbgUKoFhGhDcwWJgGp.d.xcP81aCtFv0C.KebE8ToAeVxG0Poi', 'scope' => 'admin', 'last_activity' => '2024-07-15 20:46:01', 'remember_token' => NULL, 'created_at' => '2023-07-13 18:14:24', 'updated_at' => '2024-07-15 17:16:01')
        );
        foreach ($data as $item) {
            \App\Models\User::create($item);
        }
    }
}
