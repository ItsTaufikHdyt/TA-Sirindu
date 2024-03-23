<?php

namespace App\Exports;

use App\Models\AllData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;


class AnakExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $req;

    function __construct($req)
    {
        $this->req = $req;
    }
    public function query()
    {
        if ($this->req->from_date != '' && $this->req->to_date != '') {
            if ($this->req->id_kec !== "0" && $this->req->id_kec !== null) {
                if ($this->req->id_puskesmas !== "0" && $this->req->id_puskesmas !== null) {
                    $data = DB::table('alldata')->whereBetween('tgl_kunjungan', [$this->req->from_date, $this->req->to_date])
                        ->where('idKec', $this->req->id_kec)->where('idPuskes', $this->req->id_puskesmas)
                        ->orderBy('id');

                    if ($this->req->id_posyandu !== "0" && $this->req->id_posyandu !== null) {
                        $data = DB::table('alldata')->whereBetween('tgl_kunjungan', [$this->req->from_date, $this->req->to_date])
                            ->where('idKec', $this->req->id_kec)->where('idPuskes', $this->req->id_puskesmas)->where('idPos', $this->req->id_posyandu)
                            ->orderBy('id');
                    }
                } elseif ($this->req->id_kelurahan !== "0" && $this->req->id_kelurahan !== null) {
                    $data = DB::table('alldata')->whereBetween('tgl_kunjungan', [$this->req->from_date, $this->req->to_date])
                        ->where('idKec', $this->req->id_kec)->where('idKel', $this->req->id_kelurahan)
                        ->orderBy('id');

                    if ($this->req->id_rt !== "0" && $this->req->id_rt !== null) {
                        $data = DB::table('alldata')->whereBetween('tgl_kunjungan', [$this->req->from_date, $this->req->to_date])
                            ->where('idKec', $this->req->id_kec)->where('idKel', $this->req->id_kelurahan)->where('idRt', $this->req->id_rt)
                            ->orderBy('id');
                    }
                } else {
                    $data =  DB::table('alldata')->whereBetween('tgl_kunjungan', [$this->req->from_date, $this->req->to_date])->where('idKec', $this->req->id_kec)->orderBy('id');
                }
            }
        } else {
            $data = DB::table('alldata')->whereBetween('tgl_kunjungan', [$this->req->from_date, $this->req->to_date])->orderBy('id');
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'Id',
            'No KK',
            'NIK',
            'Nama',
        ];
    }

    public function map($data): array
    {
        return [
            [
                $data->id,
                $data->no_kk,
                $data->nik,
                $data->nama,
            ]
        ];
    }

}
