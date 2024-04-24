<?php

namespace App\Http\Controllers;

use App\Exports\AllExport;
use App\Repositories\Admin\User\UserRepository as UserInterface;
use App\Repositories\Admin\Anak\AnakRepository as AnakInterface;
use App\Repositories\Admin\Fuzzy\FuzzyRepository as FuzzyInterface;
use App\Http\Requests\Admin\User\storeUserRequest;
use App\Http\Requests\Admin\Anak\storeAnakRequest;
use App\Models\Anak;
use App\Models\DataAnak;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exports\AnakExport;
use App\Models\AllData;
use App\Models\Fuzzy;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;


use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    protected $userRepository;
    protected $anakRepository;
    protected $fuzzyRepository;

    public function __construct(
        UserInterface $userRepository,
        AnakInterface $anakRepository,
        FuzzyInterface $fuzzyRepository
    ) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->anakRepository = $anakRepository;
        $this->fuzzyRepository = $fuzzyRepository;
    }

    /*------------------------------------------
--------------------------------------------
ANAK
--------------------------------------------
--------------------------------------------*/

    public function anak()
    {
        return view('admin.anak.index');
    }

    public function getAnak()
    {
        $data = Anak::select('id', 'nama', 'nama_ibu', 'nama_ayah', 'jk', 'tempat_lahir', 'tgl_lahir');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('edit', function ($data) {
                //$btn = '<a class="btn btn-warning" href="#" target="_blank">edit</a>';
                $btn = '
                <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Edit
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="' . route('admin.editAnak', $data->id) . '">Edit Data Anak</a>
                    <a class="dropdown-item" href="' . route('admin.showAnak', $data->id) . '">Show Data Anak</a>
                    <a class="dropdown-item" href="' . route('admin.dataAnak', $data->id) . '">Tambah Data Berkala Anak</a>
                </div>
                </div>
                ';
                return $btn;
            })
            ->setRowId('id')
            ->editColumn('delete', function ($data) {
                $btn = ' <button onclick="deleteItemAnak(this)" class="btn btn-danger" data-id=' . $data->id . '>Delete</button>';
                return $btn;
            })
            ->rawColumns(['edit'])
            ->rawColumns(['delete'])
            ->escapeColumns([])
            ->make(true);
    }

    public function getAnakAdmin()
    {
        $data = Anak::select('id', 'nama', 'nama_ibu', 'nama_ayah', 'jk', 'tempat_lahir', 'tgl_lahir');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('edit', function ($data) {
                //$btn = '<a class="btn btn-warning" href="#" target="_blank">edit</a>';
                $btn = '
                <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Edit
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="' . route('admin.editAnak', $data->id) . '">Edit Data Anak</a>
                    <a class="dropdown-item" href="' . route('admin.showAnak', $data->id) . '">Show Data Anak</a>
                    <a class="dropdown-item" href="' . route('admin.dataAnak', $data->id) . '">Tambah Data Berkala Anak</a>
                </div>
                </div>
                ';
                return $btn;
            })
            ->setRowId('id')
            ->editColumn('delete', function ($data) {
                $btn = ' <button onclick="deleteItemAnak(this)" class="btn btn-danger" data-id=' . $data->id . '>Delete</button>';
                return $btn;
            })
            ->rawColumns(['edit'])
            ->rawColumns(['delete'])
            ->escapeColumns([])
            ->make(true);
    }

    public function createAnak()
    {
        return view('admin.anak.create');
    }

    public function editAnak($id)
    {
        $anak = Anak::find($id);
        $dt = DataAnak::where('id_anak', $id)->first();
        $dataAnak = DataAnak::where('id_anak', $id)->get();
        return view('admin.anak.edit', compact('anak', 'dt', 'dataAnak'));
    }

    public function updateAnak(Request $request, $id)
    {
        try {
            $anak = $this->anakRepository->updateAnak($request, $id);
            Alert::success('Anak', 'Berhasil Mengubah Data');
            return redirect()->route('admin.anak');
        } catch (\Throwable $e) {
            Alert::error('Anak', 'Gagal Mengubah Data');
            return redirect()->route('admin.anak');
        }
    }

    public function storeAnak(storeAnakRequest $request)
    {
        try {
            $anak = $this->anakRepository->storeAnak($request);
            Alert::success('Anak', 'Berhasil Menambahkan Data');
            return redirect()->route('admin.anak');
        } catch (\Throwable $e) {
            Alert::error('Anak', 'Gagal Menambahkan Data');
            return redirect()->route('admin.anak');
        }
    }

    public function showAnak($id)
    {
        $anak = Anak::find($id);
        $dataAnak = DB::table('anak')
            ->join('data_anak', 'anak.id', '=', 'data_anak.id_anak')
            ->select('jk', 'bln', 'posisi', 'tb', 'bb')
            ->where('data_anak.id_anak', $id)
            ->get();
        //zscore
        $hasilx = getZscore($dataAnak);

        //BB/U ->Median ->Simpangan Baku ->ZScore BB/U
        $bbu = getBB_U($dataAnak);
        //TB/U ->Median ->Simpangan Baku ->ZScore TB/U
        $tbu = getTB_U($dataAnak);
        //BB/TB ->Median ->Simpangan Baku ->ZScore BB/TB
        $bbtb = getBB_TB($dataAnak);
        //IMT/U ->Median ->Simpangan Baku ->ZScore IMT/U
        $imtu = getIMT_U($dataAnak);

        //****************** himpunan fuzzy ******************
        //BB/U
        $fuzzySet1 =  DB::table('fuzzy')
            ->select('name', 'a', 'b', 'c', 'd', 'type', 'fuzzy_set')
            ->where('fuzzy_set', 1)
            ->get();
        //TB/U PB/U
        $fuzzySet2 =  DB::table('fuzzy')
            ->select('name', 'a', 'b', 'c', 'd', 'type', 'fuzzy_set')
            ->where('fuzzy_set', 2)
            ->get();
        //BB/TB BB/PB
        $fuzzySet3 =  DB::table('fuzzy')
            ->select('name', 'a', 'b', 'c', 'd', 'type', 'fuzzy_set')
            ->where('fuzzy_set', 3)
            ->get();
        //IMT/U
        $fuzzySet4 =  DB::table('fuzzy')
            ->select('name', 'a', 'b', 'c', 'd', 'type', 'fuzzy_set')
            ->where('fuzzy_set', 4)
            ->get();

        //dd($bbu,$tbu,$bbtb,$imtu);


        //******************************** FUZZY BB/U ****************************************//
        //Menghitung Derajat Fuzzy Ke Setiap Himpunan
        $resultFuzzyBB_U = [];
        foreach ($bbu as $key => $bbuValue) {

            $dataFuzzyBB_U = fuzzyBB_U($bbuValue['bbu'], $fuzzySet1);
            // Mendapatkan nilai maksimum dari array fuzzy
            $maxValue = max($dataFuzzyBB_U);

            // Mendapatkan kunci (key) yang terkait dengan nilai maksimum
            $maxKey = array_search($maxValue, $dataFuzzyBB_U);

            // Menyimpan data tertinggi ke dalam array resultFuzzyBB_U
            $resultFuzzyBB_U[] = [
                'BBSK' => $dataFuzzyBB_U['BBSK'],
                'BBK' => $dataFuzzyBB_U['BBK'],
                'BBN' => $dataFuzzyBB_U['BBN'],
                'RBBL' => $dataFuzzyBB_U['RBBL'],
                'maxKey' => $maxKey,
                'maxValue' => $maxValue
            ];
        }
        //dd($bbu,$resultFuzzyBB_U);

        //******************************** FUZZY TB/U ****************************************//
        //Menghitung Derajat Fuzzy Ke Setiap Himpunan
        $resultFuzzyTB_U = [];
        foreach ($tbu as $key => $tbuValue) {

            $dataFuzzyTB_U = fuzzyTB_U($tbuValue['tbu'], $fuzzySet2);
            // Mendapatkan nilai maksimum dari array fuzzy
            $maxValue = max($dataFuzzyTB_U);

            // Mendapatkan kunci (key) yang terkait dengan nilai maksimum
            $maxKey = array_search($maxValue, $dataFuzzyTB_U);

            // Menyimpan data tertinggi ke dalam array resultFuzzyTB_U
            $resultFuzzyTB_U[] = [
                'SP' => $dataFuzzyTB_U['SP'],
                'P' => $dataFuzzyTB_U['P'],
                'N' => $dataFuzzyTB_U['N'],
                'T' => $dataFuzzyTB_U['T'],
                'maxKey' => $maxKey,
                'maxValue' => $maxValue
            ];
        }
        // dd($tbu,$resultFuzzyTB_U);

        //******************************** FUZZY BB/TB ****************************************//
        //Menghitung Derajat Fuzzy Ke Setiap Himpunan
        $resultFuzzyBB_TB = [];
        foreach ($bbtb as $key => $bbtbValue) {

            $dataFuzzyBB_TB = fuzzyBB_TB($bbtbValue['bbtb'], $fuzzySet3);
            // Mendapatkan nilai maksimum dari array fuzzy
            $maxValue = max($dataFuzzyBB_TB);

            // Mendapatkan kunci (key) yang terkait dengan nilai maksimum
            $maxKey = array_search($maxValue, $dataFuzzyBB_TB);

            // Menyimpan data tertinggi ke dalam array resultFuzzyTB_U
            $resultFuzzyBB_TB[] = [
                'GBK' => $dataFuzzyBB_TB['GBK'],
                'GK' => $dataFuzzyBB_TB['GK'],
                'GB' => $dataFuzzyBB_TB['GB'],
                'BGL' => $dataFuzzyBB_TB['BGL'],
                'GL' => $dataFuzzyBB_TB['GL'],
                'O' => $dataFuzzyBB_TB['O'],
                'maxKey' => $maxKey,
                'maxValue' => $maxValue
            ];
        }
        //dd($bbtb,$resultFuzzyBB_TB);

        //******************************** FUZZY IMT/U ****************************************//
        //Menghitung Derajat Fuzzy Ke Setiap Himpunan
        $resultFuzzyIMT_U = [];
        foreach ($imtu as $key => $imtValue) {

            $dataFuzzyIMT_U = fuzzyBB_TB($imtValue['imtu'], $fuzzySet4);
            // Mendapatkan nilai maksimum dari array fuzzy
            $maxValue = max($dataFuzzyIMT_U);

            // Mendapatkan kunci (key) yang terkait dengan nilai maksimum
            $maxKey = array_search($maxValue, $dataFuzzyIMT_U);

            // Menyimpan data tertinggi ke dalam array resultFuzzyTB_U
            $resultFuzzyIMT_U[] = [
                'GBK' => $dataFuzzyIMT_U['GBK'],
                'GK' => $dataFuzzyIMT_U['GK'],
                'GB' => $dataFuzzyIMT_U['GB'],
                'BGL' => $dataFuzzyIMT_U['BGL'],
                'GL' => $dataFuzzyIMT_U['GL'],
                'O' => $dataFuzzyIMT_U['O'],
                'maxKey' => $maxKey,
                'maxValue' => $maxValue
            ];
        }
        // dd($imtu,$resultFuzzyIMT_U);

        return view('admin.anak.show', compact(
            'anak',
            'bbu',
            'tbu',
            'bbtb',
            'imtu',
            'resultFuzzyBB_U',
            'resultFuzzyTB_U',
            'resultFuzzyBB_TB',
            'resultFuzzyIMT_U'
        ))->with('hasilx', $hasilx);
    }


    public function chartAnak($id)
    {
        $anak = Anak::find($id);
        return view('admin.anak.chart', compact('anak'));
    }

    public function getChartAnak($id)
    {
        $tbAnak = DB::table('anak')
            ->join('data_anak', 'anak.id', '=', 'data_anak.id_anak')
            ->select('tb')
            ->where('data_anak.id_anak', $id)
            ->get();

        $blnAnak = DB::table('anak')
            ->join('data_anak', 'anak.id', '=', 'data_anak.id_anak')
            ->select('bln')
            ->where('data_anak.id_anak', $id)
            ->get();

        $bbAnak = DB::table('anak')
            ->join('data_anak', 'anak.id', '=', 'data_anak.id_anak')
            ->select('bb')
            ->where('data_anak.id_anak', $id)
            ->get();

        return response()->json([
            'tb' => $tbAnak,
            'bln' => $blnAnak,
            'bb' => $bbAnak,

        ]);
    }

    public function destroyAnak($id)
    {
        $this->anakRepository->destroyAnak($id);
        return response()->json([
            'success' => true
        ]);
    }

    public function dataAnak($id)
    {
        $anak = Anak::find($id);
        $query = DB::table('data_anak')->where('id_anak', $id)->max('bln');
        // $query === NULL ? $bulanSekarang = 0 : $bulanSekarang = $query + 1;
        $bulanSekarang = $query + 1;
        return view('admin.anak.data-anak', compact('anak', 'bulanSekarang'));
    }

    public function storeDataAnak(Request $request)
    {
        try {
            $this->anakRepository->storeDataAnak($request);
            return redirect()->route('admin.anak');
            Alert::success('Data Anak', 'Berhasil Menambahkan Data');
        } catch (\Throwable $e) {
            return redirect()->route('admin.anak');
            Alert::error('Data Anak', 'Berhasil Menambahkan Data');
        }
    }

    public function updateDataAnak(Request $request, $id)
    {
        try {
            $this->anakRepository->updateDataAnak($request, $id);
            Alert::success('Anak', 'Berhasil Mengubah Data Berkala Anak');
            return redirect()->route('admin.anak');
        } catch (\Throwable $e) {
            Alert::error('Anak', 'Gagal Mengubah Data Berkala Anak');
            return redirect()->route('admin.anak');
        }
    }



    public function exportAllExcel()
    {
        //return Excel::download(new AllExport, 'all-data-anak.xlsx');
        $data = AllData::all();
        $datax = AllData::all()->toArray();
        $hasilx = getZscore($data);

        //BB/U ->Median ->Simpangan Baku ->ZScore BB/U
        $bbu = getBB_U($data);
        //TB/U ->Median ->Simpangan Baku ->ZScore TB/U
        $tbu = getTB_U($data);
        //BB/TB ->Median ->Simpangan Baku ->ZScore BB/TB
        $bbtb = getBB_TB($data);
        //IMT/U ->Median ->Simpangan Baku ->ZScore IMT/U
        $imtu = getIMT_U($data);

        //****************** himpunan fuzzy ******************
        //BB/U
        $fuzzySet1 =  DB::table('fuzzy')
            ->select('name', 'a', 'b', 'c', 'd', 'type', 'fuzzy_set')
            ->where('fuzzy_set', 1)
            ->get();
        //TB/U PB/U
        $fuzzySet2 =  DB::table('fuzzy')
            ->select('name', 'a', 'b', 'c', 'd', 'type', 'fuzzy_set')
            ->where('fuzzy_set', 2)
            ->get();
        //BB/TB BB/PB
        $fuzzySet3 =  DB::table('fuzzy')
            ->select('name', 'a', 'b', 'c', 'd', 'type', 'fuzzy_set')
            ->where('fuzzy_set', 3)
            ->get();
        //IMT/U
        $fuzzySet4 =  DB::table('fuzzy')
            ->select('name', 'a', 'b', 'c', 'd', 'type', 'fuzzy_set')
            ->where('fuzzy_set', 4)
            ->get();

        //******************************** FUZZY BB/U ****************************************//
        //Menghitung Derajat Fuzzy Ke Setiap Himpunan
        $resultFuzzyBB_U = [];
        foreach ($bbu as $key => $bbuValue) {

            $dataFuzzyBB_U = fuzzyBB_U($bbuValue['bbu'], $fuzzySet1);
            // Mendapatkan nilai maksimum dari array fuzzy
            $maxValue = max($dataFuzzyBB_U);

            // Mendapatkan kunci (key) yang terkait dengan nilai maksimum
            $maxKey = array_search($maxValue, $dataFuzzyBB_U);

            // Menyimpan data tertinggi ke dalam array resultFuzzyBB_U
            $resultFuzzyBB_U[] = [
                'BBSK' => $dataFuzzyBB_U['BBSK'],
                'BBK' => $dataFuzzyBB_U['BBK'],
                'BBN' => $dataFuzzyBB_U['BBN'],
                'RBBL' => $dataFuzzyBB_U['RBBL'],
                'maxKey' => $maxKey,
                'maxValue' => $maxValue
            ];
        }

        //******************************** FUZZY TB/U ****************************************//
        //Menghitung Derajat Fuzzy Ke Setiap Himpunan
        $resultFuzzyTB_U = [];
        foreach ($tbu as $key => $tbuValue) {

            $dataFuzzyTB_U = fuzzyTB_U($tbuValue['tbu'], $fuzzySet2);
            // Mendapatkan nilai maksimum dari array fuzzy
            $maxValue = max($dataFuzzyTB_U);

            // Mendapatkan kunci (key) yang terkait dengan nilai maksimum
            $maxKey = array_search($maxValue, $dataFuzzyTB_U);

            // Menyimpan data tertinggi ke dalam array resultFuzzyTB_U
            $resultFuzzyTB_U[] = [
                'SP' => $dataFuzzyTB_U['SP'],
                'P' => $dataFuzzyTB_U['P'],
                'N' => $dataFuzzyTB_U['N'],
                'T' => $dataFuzzyTB_U['T'],
                'maxKey' => $maxKey,
                'maxValue' => $maxValue
            ];
        }
        //******************************** FUZZY BB/TB ****************************************//
        //Menghitung Derajat Fuzzy Ke Setiap Himpunan
        $resultFuzzyBB_TB = [];
        foreach ($bbtb as $key => $bbtbValue) {

            $dataFuzzyBB_TB = fuzzyBB_TB($bbtbValue['bbtb'], $fuzzySet3);
            // Mendapatkan nilai maksimum dari array fuzzy
            $maxValue = max($dataFuzzyBB_TB);

            // Mendapatkan kunci (key) yang terkait dengan nilai maksimum
            $maxKey = array_search($maxValue, $dataFuzzyBB_TB);

            // Menyimpan data tertinggi ke dalam array resultFuzzyTB_U
            $resultFuzzyBB_TB[] = [
                'GBK' => $dataFuzzyBB_TB['GBK'],
                'GK' => $dataFuzzyBB_TB['GK'],
                'GB' => $dataFuzzyBB_TB['GB'],
                'BGL' => $dataFuzzyBB_TB['BGL'],
                'GL' => $dataFuzzyBB_TB['GL'],
                'O' => $dataFuzzyBB_TB['O'],
                'maxKey' => $maxKey,
                'maxValue' => $maxValue
            ];
        }
        // dd($bbtb[10],$resultFuzzyBB_TB[10]);
        //******************************** FUZZY IMT/U ****************************************//
        //Menghitung Derajat Fuzzy Ke Setiap Himpunan
        $resultFuzzyIMT_U = [];
        foreach ($imtu as $key => $imtValue) {

            $dataFuzzyIMT_U = fuzzyBB_TB($imtValue['imtu'], $fuzzySet4);
            // Mendapatkan nilai maksimum dari array fuzzy
            $maxValue = max($dataFuzzyIMT_U);

            // Mendapatkan kunci (key) yang terkait dengan nilai maksimum
            $maxKey = array_search($maxValue, $dataFuzzyIMT_U);

            // Menyimpan data tertinggi ke dalam array resultFuzzyTB_U
            $resultFuzzyIMT_U[] = [
                'GBK' => $dataFuzzyIMT_U['GBK'],
                'GK' => $dataFuzzyIMT_U['GK'],
                'GB' => $dataFuzzyIMT_U['GB'],
                'BGL' => $dataFuzzyIMT_U['BGL'],
                'GL' => $dataFuzzyIMT_U['GL'],
                'O' => $dataFuzzyIMT_U['O'],
                'maxKey' => $maxKey,
                'maxValue' => $maxValue
            ];
        }
        $combinedData = [
            'datax' => $datax,
            'hasilx' => $hasilx,
            'bbu' => $bbu,
            'resultFuzzyBB_U' => $resultFuzzyBB_U,
            'tbu' => $tbu,
            'resultFuzzyTB_U' => $resultFuzzyTB_U,
            'bbtb' => $bbtb,
            'resultFuzzyBB_TB' => $resultFuzzyBB_TB,
            'imtu' => $imtu,
            'resultFuzzyIMT_U' => $resultFuzzyIMT_U,
        ];
        

        $resultData = [];
        foreach ($combinedData['datax'] as $key => $data) {
            
            if ($combinedData['resultFuzzyBB_U'][$key]['maxKey'] == 'BBSK') {
                $fuzzyBBU = 'Berat Badan Sangat Kurang';
            } elseif ($combinedData['resultFuzzyBB_U'][$key]['maxKey'] == 'BBK') {
                $fuzzyBBU = 'Berat Badan Kurang';
            } elseif ($combinedData['resultFuzzyBB_U'][$key]['maxKey'] == 'BBN') {
                $fuzzyBBU = 'Berat Badan Normal';
            } elseif ($combinedData['resultFuzzyBB_U'][$key]['maxKey'] == 'RBBL') {
                $fuzzyBBU = 'Risiko Berat Badan Lebih';
            }
            //tbu
            if ($combinedData['resultFuzzyTB_U'][$key]['maxKey'] == 'SP') {
                $fuzzyTBU = 'Sangat Pendek';
            } elseif ($combinedData['resultFuzzyTB_U'][$key]['maxKey'] == 'P') {
                $fuzzyTBU = 'Pendek';
            } elseif ($combinedData['resultFuzzyTB_U'][$key]['maxKey'] == 'N') {
                $fuzzyTBU = 'Normal';
            } elseif ($combinedData['resultFuzzyTB_U'][$key]['maxKey'] == 'T') {
                $fuzzyTBU = 'Tingi';
            }
            //bbtb
            if ($combinedData['resultFuzzyBB_TB'][$key]['maxKey']  == 'GBK') {
                $fuzzyBBTB = 'Gizi Buruk';
            } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'GK') {
                $fuzzyBBTB = 'Gizi Kurang';
            } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'GB') {
                $fuzzyBBTB = 'Gizi Baik';
            } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'BGL') {
                $fuzzyBBTB = 'Berisiko Gizi Berlebih';
            } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'GL') {
                $fuzzyBBTB = 'Gizi Lebih';
            } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'O') {
                $fuzzyBBTB = 'Obesitas';
            }
            //imtu
            if ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'GBK') {
                $fuzzyIMTU  = 'Gizi Buruk';
            } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'GK') {
                $fuzzyIMTU = 'Gizi Kurang';
            } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'GB') {
                $fuzzyIMTU = 'Gizi Baik';
            } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'BGL') {
                $fuzzyIMTU = 'Berisiko Gizi Berlebih';
            } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'GL') {
                $fuzzyIMTU = 'Gizi Lebih';
            } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'O') {
                $fuzzyIMTU = 'Obesitas';
            }
            
            $resultDatax = [
                'Nama' => $combinedData['datax'][$key]['nama'],
                'Nama Ibu' => $combinedData['datax'][$key]['nama_ibu'],
                'Nama Ayah' => $combinedData['datax'][$key]['nama_ayah'],
                'Jenis Kelamin' => ($combinedData['datax'][$key]['jk'] == 1) ? 'Laki-laki' : 'Perempuan',
                'Tempat Lahir' => $combinedData['datax'][$key]['tempat_lahir'],
                'Tanggal Lahir' => $combinedData['datax'][$key]['tgl_lahir'],
                'Bulan' => $combinedData['datax'][$key]['bln'],
                'Tinggi Badan' => $combinedData['datax'][$key]['tb'],
                'Berat Badan' => $combinedData['datax'][$key]['bb'],
                'BMI' => $combinedData['datax'][$key]['bb'] / pow(($combinedData['datax'][$key]['tb'] * 0.01), 2),

                'Median BB/U' => $combinedData['bbu'][$key]['b'],
                'SB BB/U' => ($combinedData['bbu'][$key]['a'] == null) ? $combinedData['bbu'][$key]['c'] : $combinedData['bbu'][$key]['a'],
                'Zscore BB/U' => $combinedData['bbu'][$key]['bbu'],

                'Median TB/U' => $combinedData['tbu'][$key]['b'],
                'SB TB/U' => ($combinedData['tbu'][$key]['a'] == null) ? $combinedData['tbu'][$key]['c'] : $combinedData['tbu'][$key]['a'],
                'Zscore TB/U' => $combinedData['tbu'][$key]['tbu'],

                'Median BB/TB' => $combinedData['bbtb'][$key]['b'],
                'SB BB/TB' => ($combinedData['bbtb'][$key]['a'] == null) ? $combinedData['bbtb'][$key]['c'] : $combinedData['bbtb'][$key]['a'],
                'Zscore BB/TB' => $combinedData['bbtb'][$key]['bbtb'],

                'Median IMT/U' => $combinedData['imtu'][$key]['b'],
                'SB IMT/U' => ($combinedData['imtu'][$key]['a'] == null) ? $combinedData['imtu'][$key]['c'] : $combinedData['imtu'][$key]['a'],
                'Zscore IMT/U' => $combinedData['imtu'][$key]['imtu'],

                'BBSK' => $combinedData['resultFuzzyBB_U'][$key]['BBSK'],
                'BBK' => $combinedData['resultFuzzyBB_U'][$key]['BBK'],
                'BBN' => $combinedData['resultFuzzyBB_U'][$key]['BBN'],
                'RBBL' => $combinedData['resultFuzzyBB_U'][$key]['RBBL'],
                'Fuzzy BB/U' => $fuzzyBBU,
                'BB/U' => $combinedData['hasilx'][$key]['bb'],

                'SP' => $combinedData['resultFuzzyTB_U'][$key]['SP'],
                'P' => $combinedData['resultFuzzyTB_U'][$key]['P'],
                'N' => $combinedData['resultFuzzyTB_U'][$key]['N'],
                'T' => $combinedData['resultFuzzyTB_U'][$key]['T'],
                'Fuzzy TB/U' => $fuzzyTBU,
                'TB/U' => $combinedData['hasilx'][$key]['tb'],

                'GBK' =>$combinedData['resultFuzzyBB_TB'][$key]['GBK'],
                'GK' =>$combinedData['resultFuzzyBB_TB'][$key]['GK'],
                'GB' =>$combinedData['resultFuzzyBB_TB'][$key]['GB'],
                'BGL' =>$combinedData['resultFuzzyBB_TB'][$key]['BGL'],
                'GL' =>$combinedData['resultFuzzyBB_TB'][$key]['GL'],
                'O' =>$combinedData['resultFuzzyBB_TB'][$key]['O'],
                'Fuzzy BB/TB' => $fuzzyBBTB,
                'BB/TB' =>$combinedData['hasilx'][$key]['bt'],

                'GBK-IMT' =>$combinedData['resultFuzzyIMT_U'][$key]['GBK'],
                'GK-IMT' =>$combinedData['resultFuzzyIMT_U'][$key]['GK'],
                'GB-IMT' =>$combinedData['resultFuzzyIMT_U'][$key]['GB'],
                'BGL-IMT' =>$combinedData['resultFuzzyIMT_U'][$key]['BGL'],
                'GL-IMT' =>$combinedData['resultFuzzyIMT_U'][$key]['GL'],
                'O-IMT' =>$combinedData['resultFuzzyIMT_U'][$key]['O'],
                'Fuzzy IMTU/U' => $fuzzyIMTU,
                'IMTU/U' => $combinedData['hasilx'][$key]['imt'],

                // 'Nama' => $combinedData['datax'][$key]['nama'],
                // 'Nama Ibu' => $combinedData['datax'][$key]['nama_ibu'],
                // 'Nama Ayah' => $combinedData['datax'][$key]['nama_ayah'],
                // 'Jenis Kelamin' => ($combinedData['datax'][$key]['jk'] == 1) ? 'Laki-laki' : 'Perempuan',
                // 'Tempat Lahir' => $combinedData['datax'][$key]['tempat_lahir'],
                // 'Tanggal Lahir' => $combinedData['datax'][$key]['tgl_lahir'],
                // 'Bulan' => $combinedData['datax'][$key]['bln'],
                // 'Tinggi Badan' => $combinedData['datax'][$key]['tb'],
                // 'Berat Badan' => $combinedData['datax'][$key]['bb'],
                // 'BMI' => $combinedData['datax'][$key]['bb'] / pow(($combinedData['datax'][$key]['tb'] * 0.01), 2),
                // 'Fuzzy BB/U' => $fuzzyBBU,
                // 'BB/U' => $combinedData['hasilx'][$key]['bb'],
                // 'Fuzzy TB/U' => $fuzzyTBU,
                // 'TB/U' => $combinedData['hasilx'][$key]['tb'],
                // 'Fuzzy BB/TB' => $fuzzyBBTB,
                // 'BB/TB' => $combinedData['hasilx'][$key]['bt'],
                // 'Fuzzy IMTU/U' => $fuzzyIMTU,
                // 'IMTU/U' => $combinedData['hasilx'][$key]['imt'],

            ];
            $resultData[] = $resultDatax;
        }
        // dd(count($resultData),$resultData[10]);

        return FastExcel($resultData)->download('data-anak.xlsx');
    }

    public function fuzzy()
    {
        $fuzzy1 = Fuzzy::where('fuzzy_set', 1)->get();
        $fuzzy2 = Fuzzy::where('fuzzy_set', 2)->get();
        $fuzzy3 = Fuzzy::where('fuzzy_set', 3)->get();
        $fuzzy4 = Fuzzy::where('fuzzy_set', 4)->get();

        return view('admin.fuzzy.index', compact('fuzzy1', 'fuzzy2', 'fuzzy3', 'fuzzy4'));
    }

    public function storeFuzzy(Request $request)
    {

        try {
            $this->fuzzyRepository->storeFuzzy($request);
            Alert::success('Himpunan Fuzzy', 'Berhasil Menambahkan Data Himpunan Fuzzy');
            return redirect()->route('admin.fuzzy');
        } catch (\Throwable $e) {
            Alert::error('Himpunan Fuzzy', 'Berhasil Menambahkan Data Himpunan Fuzzy');
            return redirect()->route('admin.fuzzy');
        }
    }

    public function updateFuzzy(Request $request, $id)
    {
        try {
            $this->fuzzyRepository->updateFuzzy($request, $id);
            Alert::success('Himpunan Fuzzy', 'Berhasil Mengupdate Data Himpunan Fuzzy');
            return redirect()->route('admin.fuzzy');
        } catch (\Throwable $e) {
            Alert::error('Himpunan Fuzzy', 'Gagal Mengupdate Data Himpunan Fuzzy');
            return redirect()->route('admin.fuzzy');
        }
    }

    public function destroyFuzzy($id)
    {
        try {
            $fuzzy = $this->fuzzyRepository->destroyFuzzy($id);
            return redirect()->route('admin.fuzzy');
        } catch (\Throwable $e) {
            return redirect()->route('admin.fuzzy');
        }
    }
    // 

    /*------------------------------------------
--------------------------------------------
All Super Admin Controller
--------------------------------------------
--------------------------------------------*/
    public function superAdminHome()
    {
        return view('admin.dashboard.super_admin');
    }
    /*------------------------------------------
--------------------------------------------
All Super Admin Controller
--------------------------------------------
--------------------------------------------*/
    public function adminHome()
    {
        return view('admin.dashboard.admin');
    }
    /*------------------------------------------
--------------------------------------------
All User Controller
--------------------------------------------
--------------------------------------------*/
    public function user()
    {
        $user = User::all();
        return view('admin.user.index', compact('user'));
    }

    public function storeUser(storeUserRequest $request)
    {
        try {
            $user = $this->userRepository->storeUser($request);
            return redirect()->route('super.admin.user');
        } catch (\Throwable $e) {
            return redirect()->route('super.admin.user');
        }
    }

    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function updateUser(storeUserRequest $request, $id)
    {
        try {
            $user = $this->userRepository->updateUser($request, $id);
            return redirect()->route('super.admin.user');
        } catch (\Throwable $e) {
            return redirect()->route('super.admin.user');
        }
    }
    public function destroyUser($id)
    {
        try {
            $user = $this->userRepository->destroyUser($id);
            return redirect()->route('super.admin.user');
        } catch (\Throwable $e) {
            return redirect()->route('super.admin.user');
        }
    }
}
