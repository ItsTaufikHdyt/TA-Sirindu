<?php

namespace Database\Seeders;

use App\Models\Puskesmas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PuskesmasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $puskes = [
            [
                'id' => '1',
                'id_kecamatan' => 1,
                'name' => 'Bontang Barat',
            ],
            [
                'id' => '2',
                'id_kecamatan' => 2,
                'name' => 'Bontang Utara I',
            ],
            [
                'id' => '3',
                'id_kecamatan' => 2,
                'name' => 'Bontang Utara II',
            ],
            [
                'id' => '4',
                'id_kecamatan' => 3,
                'name' => 'Bontang Lestari',
            ],
            [
                'id' => '5',
                'id_kecamatan' => 3,
                'name' => 'Bontang Selatan I',
            ],
            [
                'id' => '6',
                'id_kecamatan' => 3,
                'name' => 'Bontang Selatan II',
            ],
        ];

        foreach ($puskes as $key => $puskes) {
            Puskesmas::create($puskes);
        }
    }
}
