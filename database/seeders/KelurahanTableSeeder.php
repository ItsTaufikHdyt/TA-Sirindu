<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelurahanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kel = [
            //Bontang Barat
            [
                'id' => '1',
                'id_kecamatan' => '1',
                'name' => 'Belimbing',
            ],
            [
                'id' => '2',
                'id_kecamatan' => '1',
                'name' => 'Kanaan',
            ],
            [
                'id' => '3',
                'id_kecamatan' => '1',
                'name' => 'Telihan',
            ],
            //Bontang Selatan
            [
                'id' => '4',
                'id_kecamatan' => '3',
                'name' => 'Berbas Pantai',
            ],
            [
                'id' => '5',
                'id_kecamatan' => '3',
                'name' => 'Berbas Tengah',
            ],
            [
                'id' => '6',
                'id_kecamatan' => '3',
                'name' => 'Bontang Lestari',
            ],
            [
                'id' => '7',
                'id_kecamatan' => '3',
                'name' => 'Satimpo',
            ],
            [
                'id' => '8',
                'id_kecamatan' => '3',
                'name' => 'Tanjung Laut',
            ],
            [
                'id' => '9',
                'id_kecamatan' => '3',
                'name' => 'Tanjung Laut Indah',
            ],
            //Bontang Utara
            [
                'id' => '10',
                'id_kecamatan' => '2',
                'name' => 'Api Api',
            ],
            [
                'id' => '11',
                'id_kecamatan' => '2',
                'name' => 'Bontang Baru',
            ],
            [
                'id' => '12',
                'id_kecamatan' => '2',
                'name' => 'Bontang Kuala',
            ],
            [
                'id' => '13',
                'id_kecamatan' => '2',
                'name' => 'Guntung',
            ],
            [
                'id' => '14',
                'id_kecamatan' => '2',
                'name' => 'Gunung Elai',
            ],
            [
                'id' => '15',
                'id_kecamatan' => '2',
                'name' => 'Loktuan',
            ],
        ];

        foreach ($kel as $key => $kel) {
            Kelurahan::create($kel);
        }
    }
}
