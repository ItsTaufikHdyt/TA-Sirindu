<?php

namespace App\Repositories\Admin\Anak;

use App\Repositories\Admin\Core\Anak\AnakRepositoryInterface;
use App\Models\Anak;
use App\Models\User;
use App\Models\DataAnak;
use App\Models\Imunisasi;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use function PHPUnit\Framework\isEmpty;

class AnakRepository implements AnakRepositoryInterface
{
    protected $anak;

    public function __contruct(
        anak $anak
    ) {
        $this->anak = $anak;
    }

    public function storeAnak($request)
     {
    //     $lahir = strtotime($request->tgl_lahir);
    //     $now = strtotime(Carbon::now());
    //     $y1 = date('Y', $lahir);
    //     $y2 = date('Y', $now);
    //     $m1 = date('m', $lahir);
    //     $m2 = date('m', $now);
    // $umur = (($y2 - $y1) * 12) + ($m2 - $m1);

        $anak_baru = Anak::create([
            'nama' => $request->nama,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'jk' => $request->jk,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
        ]);

        DataAnak::create([
            'id_anak' => $anak_baru->id,
            'bln' => $request->bln,
            'posisi' => 'L',
            'tb' => $request->tb,
            'bb' => $request->bb,
            'id_user' => Auth::user()->id,
        ]);
    }

    public function updateAnak($request, $id)
    {
        // $lahir = strtotime($request->tgl_lahir);
        // $now = strtotime(Carbon::now());
        // $y1 = date('Y', $lahir);
        // $y2 = date('Y', $now);
        // $m1 = date('m', $lahir);
        // $m2 = date('m', $now);
        // $umur = (($y2 - $y1) * 12) + ($m2 - $m1);
        $anak = Anak::find($id);
        $dt = DataAnak::where('id_anak', $id)->first();
        if ($request->id_kec == null) {
            $anak->update([
                'nama' => $request->nama,
                'nama_ibu' => $request->nama_ibu,
                'nama_ayah' => $request->nama_ayah,
                'jk' => $request->jk,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat
            ]);
            $dt->update([
                'bln' => $request->bln,
                'posisi' => 'L',
                'tb' => $request->tb,
                'bb' => $request->bb,
                'id_user' => Auth::user()->id,
            ]);
        } else {
            $anak->update([
                'nama' => $request->nama,
                'nama_ibu' => $request->nama_ibu,
                'nama_ayah' => $request->nama_ayah,
                'jk' => $request->jk,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat
            ]);
            $dt->update([
                'bln' => $request->bln,
                'posisi' => 'L',
                'tb' => $request->tb,
                'bb' => $request->bb,
                'id_user' => Auth::user()->id,
            ]);
        }
    }

    public function destroyAnak($id)
    {
        try {
            $anak = Anak::find($id);
            $anak->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeDataAnak($request)
    {
        $anak = DataAnak::create([
            'id_anak' => $request->id_anak,
            'bln' => $request->bln,
            'posisi' => $request->posisi,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'id_user' => Auth::user()->id,
        ]);
    }

    public function updateDataAnak($request, $id)
    {
        $dataAnak = DataAnak::find($id);
        $dataAnak->update([
            'posisi' => $request->posisi,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'id_user' => Auth::user()->id,
        ]);
    }
}
