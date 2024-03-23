<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Puskesmas;
use App\Models\Kelurahan;
use App\Models\Posyandu;
use App\Models\Rt;
use App\Models\AllData;
use App\Models\Anak;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function allDataAnak()
    {
        $all = AllData::all();
        return response()->json([
            'success' => true,
            'data' => $all,
        ], 201);
    }

    public function allDataDasarAnak()
    {
        $anak = Anak::all();
        return response()->json([
            'success' => true,
            'data' => $anak,
        ], 201);
    }

    public function showDataDasarAnak($id)
    {
        $anak = Anak::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $anak,
        ], 201);
    }

    public function showAllDataAnak($id)
    {
        $anak = Anak::with("dataAnak")->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $anak,
        ], 201);
    }

    public function getKecApi()
    {
        $kec = Kecamatan::all();
        return response()->json([
            'success' => true,
            'data' => $kec,
        ], 201);
    }

    public function getPuskesmasApi($id)
    {
        $puskesmas = Puskesmas::where('id_kecamatan', $id)->pluck('name', 'id');
        return response()->json([
            'success' => true,
            'data' => $puskesmas,
        ], 201);
    }

    public function getKelApi($id)
    {
        $kel = Kelurahan::where('id_kecamatan', $id)->pluck('name', 'id');
        return response()->json([
            'success' => true,
            'data' => $kel,
        ], 201);
    }

    public function getRtApi($id)
    {
        $rt = Rt::where('id_posyandu', $id)->pluck('name', 'id');
        return response()->json([
            'success' => true,
            'data' => $rt,
        ], 201);
    }

    public function getPosyanduApi($id)
    {
        $posyandu = Posyandu::where('id_puskesmas', $id)->pluck('name', 'id');
        return response()->json([
            'success' => true,
            'data' => $posyandu,
        ], 201);
    }

    public function getStuntingApi(Request $request)
    {
        $datacollection = collect([
            (object)[
                'tgl_kunjungan' => $request->tgl_kunjungan,
                'jk' => (int)$request->jk,
                'bln' => (int)$request->bln,
                'posisi' => $request->posisi,
                'tb' => (float)$request->tb,
                'bb' => (float)$request->bb,
            ]
        ]);
        
        $hasilx = getZscore($datacollection);
        return response()->json([
            'success' => true,
            'data' => $hasilx,
        ], 201);
    }
}
