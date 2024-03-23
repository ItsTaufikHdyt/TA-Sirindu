<?php

namespace Database\Seeders;

use App\Models\JenisTabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenisTabel = [
            [
                'id' => '1',
                'nama_tabel' => 'Indeks Massa Tubuh dan Umur',
            ],
            [
                'id' => '2',
                'nama_tabel' => 'Berat Badan dan Umur',
            ],
            [
                'id' => '3',
                'nama_tabel' => 'Tinggi Badan dan Umur',
            ],
            [
                'id' => '4',
                'nama_tabel' => 'Berat Badan dan Tinggi Badan',
            ],
        ];

        foreach ($jenisTabel as $key => $jenisTabel) {
            JenisTabel::create($jenisTabel);
        }
    }
}
