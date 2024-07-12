<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\Models\Anak;
use App\Models\AllData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpdController extends Controller
{
    public function index()
    {
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

        //menghitung data 
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

            // Inisialisasi variabel total untuk setiap kategori
            $totalBBSK = $totalBBK = $totalBBN = $totalRBBL = 0;
            $totalSP = $totalP = $totalN = $totalT = 0;
            $totalGBK = $totalGK = $totalGB = $totalBGL = $totalGL = $totalO = 0;
            $totalGBK_IMT = $totalGK_IMT = $totalGB_IMT = $totalBGL_IMT = $totalGL_IMT = $totalO_IMT = 0;

            foreach ($combinedData['datax'] as $key => $data) {
                // ... (your existing code)

                // Increment total for each category
                if ($combinedData['resultFuzzyBB_U'][$key]['maxKey'] == 'BBSK') {
                    $totalBBSK++;
                } elseif ($combinedData['resultFuzzyBB_U'][$key]['maxKey'] == 'BBK') {
                    $totalBBK++;
                } elseif ($combinedData['resultFuzzyBB_U'][$key]['maxKey'] == 'BBN') {
                    $totalBBN++;
                } elseif ($combinedData['resultFuzzyBB_U'][$key]['maxKey'] == 'RBBL') {
                    $totalRBBL++;
                }

                if ($combinedData['resultFuzzyTB_U'][$key]['maxKey'] == 'SP') {
                    $totalSP++;
                } elseif ($combinedData['resultFuzzyTB_U'][$key]['maxKey'] == 'P') {
                    $totalP++;
                } elseif ($combinedData['resultFuzzyTB_U'][$key]['maxKey'] == 'N') {
                    $totalN++;
                } elseif ($combinedData['resultFuzzyTB_U'][$key]['maxKey'] == 'T') {
                    $totalT++;
                }

                if ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'GBK') {
                    $totalGBK++;
                } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'GK') {
                    $totalGK++;
                } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'GB') {
                    $totalGB++;
                } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'BGL') {
                    $totalBGL++;
                } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'GL') {
                    $totalGL++;
                } elseif ($combinedData['resultFuzzyBB_TB'][$key]['maxKey'] == 'O') {
                    $totalO++;
                }

                if ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'GBK') {
                    $totalGBK_IMT++;
                } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'GK') {
                    $totalGK_IMT++;
                } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'GB') {
                    $totalGB_IMT++;
                } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'BGL') {
                    $totalBGL_IMT++;
                } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'GL') {
                    $totalGL_IMT++;
                } elseif ($combinedData['resultFuzzyIMT_U'][$key]['maxKey'] == 'O') {
                    $totalO_IMT++;
                }

                // ... (your existing code)
            }
           
        }

        //menghitung persentase data
        $totalData = count($combinedData['datax']);

        $totals = [
            'BBSK' => $totalBBSK,
            'BBK' => $totalBBK,
            'BBN' => $totalBBN,
            'RBBL' => $totalRBBL,
            'SP' => $totalSP,
            'P' => $totalP,
            'N' => $totalN,
            'T' => $totalT,
            'GBK' => $totalGBK,
            'GK' => $totalGK,
            'GB' => $totalGB,
            'BGL' => $totalBGL,
            'GL' => $totalGL,
            'O' => $totalO,
            'GBK_IMT' => $totalGBK_IMT,
            'GK_IMT' => $totalGK_IMT,
            'GB_IMT' => $totalGB_IMT,
            'BGL_IMT' => $totalBGL_IMT,
            'GL_IMT' => $totalGL_IMT,
            'O_IMT' => $totalO_IMT,
        ];

        $percentages = [];
        foreach ($totals as $key => $value) {
            $percentages[$key] = ($value / $totalData) * 100;
        }

        return view('opd',compact(
            'totalBBSK',
            'totalBBK',
            'totalBBN',
            'totalRBBL',
            'totalSP',
            'totalP',
            'totalN',
            'totalT',
            'totalGBK',
            'totalGK',
            'totalGB',
            'totalBGL',
            'totalGL',
            'totalO',
            'totalGBK_IMT',
            'totalGK_IMT',
            'totalGB_IMT',
            'totalBGL_IMT',
            'totalGL_IMT',
            'totalO_IMT',
            'percentages',
        ));
    }

    public function anak()
    {
        return view('opd.index');
    }

    public function getAnak()
    {
        $data = Anak::select('id', 'nama', 'nama_ibu', 'nama_ayah', 'jk', 'tempat_lahir', 'tgl_lahir');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('edit', function ($data) {
                //$btn = '<a class="btn btn-warning" href="#" target="_blank">edit</a>';
                $btn = '             
                    <a class="btn btn-success" href="' . route('opd.showAnak', $data->id) . '">Show Data Anak</a>
                ';
                return $btn;
            })
            ->setRowId('id')
            ->rawColumns(['edit'])
            ->escapeColumns([])
            ->make(true);
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

        return view('opd.show', compact(
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
                'Posisi' => $combinedData['datax'][$key]['posisi'],
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


            ];
            array_push($resultData, $resultDatax);

            //$resultData[] = $resultDatax;
        }
     // dd(count($resultData),$resultData[10]);

        return FastExcel($resultData)->download('data-anak.xlsx');
    }


}
