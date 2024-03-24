<?php

use Illuminate\Support\Facades\DB;
use App\Models\ZScore;

function getZscore($x)
{
    $no = 0;
    foreach ($x as $key => $data) {
        $no++;
        $tinggix = $data->tb;
        //        $tgl_kunjungan = $data->tgl_kunjungan;
        $berat = $data->bb;
        $umur = $data->bln;
        $posisi = $data->posisi;
        if ($umur < 24 && $posisi == "H") {
            $tinggix += 0.7;
        } elseif ($umur >= 24 && $posisi == "L") {
            $tinggix -= 0.7;
        }
        $tinggi = round($tinggix);
        $var = $umur <= 24 ? 1 : 2;
        $jk = $data->jk;
        $bmi = round(10000 * $berat / pow($tinggi, 2), 2);

        $err = NULL;
        if ($bmi < 10.2 || $bmi > 21.1) {
            $err = "Nilai BMI tidak normal";
        } elseif ($tinggi < 44.2 || $tinggi > 123.9) {
            $err = "Nilai Tinggi Badan tidak normal";
        } elseif ($berat < 1.9 || $berat > 31.2) {
            $err = "Nilai Berat Badan tidak normal";
        }
        $imt_u = DB::table('z_score')
            ->select('id', 'm3sd as a1', 'm2sd as b1', '1sd as c1', '2sd as d1', '3sd as e1')
            ->where([
                'var' => $var,
                'acuan' => $umur,
                'jk' => $jk,
                'jenis_tbl' => 1,
            ])->get();
        $bb_u = DB::table('z_score')
            ->select('id', 'm3sd as a2', 'm2sd as b2', '1sd as c2')
            ->where([
                'acuan' => $umur,
                'jk' => $jk,
                'jenis_tbl' => 2,
            ])->get();
        $tb_u = DB::table('z_score')
            ->select('id', 'm3sd as a3', 'm2sd as b3', '1sd as c3', '2sd as d3', '3sd as e3')
            ->where([
                'var' => $var,
                'acuan' => $umur,
                'jk' => $jk,
                'jenis_tbl' => 3,
            ])->get();
        $bt_tb = DB::table('z_score')
            ->select('id', 'm3sd as a4', 'm2sd as b4', '1sd as c4', '2sd as d4', '3sd as e4')
            ->where([
                'var' => $var,
                'acuan' => $tinggi,
                'jk' => $jk,
                'jenis_tbl' => 4,
            ])->get();
        $imt_u2 = DB::table('z_score')
            ->select('id', 'm3sd as a5', 'm2sd as b5', '1sd as c5', '2sd as d5')
            ->where([
                'var' => $var,
                'acuan' => $tinggi,
                'jk' => $jk,
                'jenis_tbl' => 5,
            ])->get();

        if ($umur <= 60) {
            if ($bmi < $imt_u[0]->a1) {
                $s1 = "Gizi buruk (severely wasted)";
            } elseif ($bmi >= $imt_u[0]->a1 && $bmi < $imt_u[0]->b1) {
                $s1 = "Gizi kurang (wasted)";
            } elseif ($bmi >= $imt_u[0]->b1 && $bmi <= $imt_u[0]->c1) {
                $s1 = "Gizi baik (normal)";
            } elseif ($bmi > $imt_u[0]->c1 && $bmi <= $imt_u[0]->d1) {
                $s1 = "Berisiko gizi lebih (possible risk of overweight)";
            } elseif ($bmi > $imt_u[0]->d1 && $bmi <= $imt_u[0]->e1) {
                $s1 = "Gizi lebih (overweight)";
            } else {
                $s1 = "Obesitas (obese)";
            }
        } elseif ($umur > 60) {
            if ($bmi < $imt_u[0]->a1) {
                $s1 = "Gizi buruk (severely thinness)";
            } elseif ($bmi >= $imt_u[0]->a1 && $bmi < $imt_u[0]->b1) {
                $s1 = "Gizi kurang (thinness)";
            } elseif ($bmi >= $imt_u[0]->b1 && $bmi <= $imt_u[0]->c1) {
                $s1 = "Gizi baik (normal)";
            } elseif ($bmi > $imt_u[0]->c1 && $bmi <= $imt_u[0]->d1) {
                $s1 = "Gizi lebih (overweight)";
            } else {
                $s1 = "Obesitas (obese)";
            }
        }


        if ($berat < $bb_u[0]->a2) {
            $s2 = "Berat badan sangat kurang (severely underweight)";
        } elseif ($berat >= $bb_u[0]->a2 && $berat < $bb_u[0]->b2) {
            $s2 = "Berat badan kurang (underweight)";
        } elseif ($berat >= $bb_u[0]->b2 && $berat <= $bb_u[0]->c2) {
            $s2 = "Berat badan normal";
        } else {
            $s2 = "Risiko Berat badan lebih";
        }

        if ($tinggi < $tb_u[0]->a3) {
            $s3 = "Sangat pendek (severely stunted)";
        } elseif ($tinggi >= $tb_u[0]->a3 && $tinggi < $tb_u[0]->b3) {
            $s3 = "Pendek (stunted)";
        } elseif ($tinggi >= $tb_u[0]->b3 && $tinggi <= $tb_u[0]->e3) {
            $s3 = "Normal";
        } else {
            $s3 = "Tinggi";
        }

        if ($tinggi < $tb_u[0]->a3) {
            $s3 = "Sangat pendek (severely stunted)";
        } elseif ($tinggi >= $tb_u[0]->a3 && $tinggi < $tb_u[0]->b3) {
            $s3 = "Pendek (stunted)";
        } elseif ($tinggi >= $tb_u[0]->b3 && $tinggi <= $tb_u[0]->e3) {
            $s3 = "Normal";
        } else {
            $s3 = "Tinggi";
        }
        try {
            if ($berat < $bt_tb[0]->a4) {
                $s4 = "Gizi buruk (severely wasted)";
            } elseif ($berat >= $bt_tb[0]->a4 && $berat < $bt_tb[0]->b4) {
                $s4 = "Gizi kurang (wasted)";
            } elseif ($berat >= $bt_tb[0]->b4 && $berat <= $bt_tb[0]->c4) {
                $s4 = "Gizi baik (normal)";
            } elseif ($berat > $bt_tb[0]->c4 && $berat <= $bt_tb[0]->d4) {
                $s4 = "Berisiko gizi lebih (possible risk of overweight)";
            } elseif ($berat > $bt_tb[0]->d4 && $berat <= $bt_tb[0]->e4) {
                $s4 = "Gizi lebih (overweight)";
            } else {
                $s4 = "Obesitas (obese)";
            }
        } catch (\Exception $e) {
            // dump('culprit : '.$key.', Error : '.$e->getMessage());
            // $s4 = $key;
            $s4 = "Data Tidak Valid";
            // continue;
        }

        $hasilx[$key] = array(
            //"tgl_kunjungan" => $tgl_kunjungan,
            "bln" => $umur,
            "tinggi" => $tinggix,
            "berat" => $berat,
            "imt" => $s1,
            "bb" => $s2,
            "tb" => $s3,
            "bt" => $s4
        );
    }

    return $hasilx;
}

function getIMT_U($x)
{
    $imtuData = [];
    foreach ($x as $key => $data) {
        $tb = $data->tb;
        $bb = $data->bb;
        $jk = $data->jk;
        $imt = $bb / ($tb * $tb);
        $umur = $data->bln;
        $var = $umur <= 24 ? 1 : 2;

        $imtumedian = DB::table('z_score')
            ->select('id', 'm1sd as a', 'sd as b', '1sd as c')
            ->where([
                'var' => $var,
                'acuan' => $umur,
                'jk' => $jk,
                'jenis_tbl' => 1,
            ])->get();
        foreach ($imtumedian as $data) {
            $a = $data->a;
            $b = $data->b;
            $c = $data->c;
        }

        if ($imt < $b) {
            $imtu = ($imt - $b) / ($b - $a);
        } elseif ($imt > $b) {
            $imtu = ($imt - $b) / ($c - $b);
        }

        $imtuData[] = [
            'bb' => $bb,
            'tb' => $tb,
            'bln' => $umur,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'imtu' => $imtu
        ];
    }


    return $imtuData;
}

function getBB_U($x)
{
    $bbuData = [];
    foreach ($x as $key => $data) {
        $bb = $data->bb;
        $tb = $data->tb;
        $jk = $data->jk;
        $umur = $data->bln;

        $bbumedian = DB::table('z_score')
            ->select('id', 'm1sd as a', 'sd as b', '1sd as c')
            ->where([
                'acuan' => $umur,
                'jk' => $jk,
                'jenis_tbl' => 2,
            ])->get();
        foreach ($bbumedian as $data) {
            $a = $data->a;
            $b = $data->b;
            $c = $data->c;
        }

        if ($bb < $b) {
            $bbu = ($bb - $b) / ($b - $a);
            $a = $a;
            $b = $b;
            $c = null;
        } elseif ($bb > $b) {
            $bbu = ($bb - $b) / ($c - $b);
            $a = null;
            $b = $b;
            $c = $c;
        }

        $bbuData[] = [
            'bb' => $bb,
            'tb' => $tb,
            'bln' => $umur,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'bbu' => $bbu
        ];
    }
    return $bbuData;
}

function getTB_U($x)
{
    $tbuData = [];
    foreach ($x as $key => $data) {
        $posisi = $data->posisi;
        $bb = $data->bb;
        $tb = $data->tb;
        $jk = $data->jk;
        $umur = $data->bln;
        $var = $umur <= 24 ? 1 : 2;
        if ($umur < 24 && $posisi == "H") {
            $tb += 0.7;
        } elseif ($umur >= 24 && $posisi == "L") {
            $tb -= 0.7;
        }
        $tinggi = round($tb);

        $tbumedian = DB::table('z_score')
            ->select('id', 'm1sd as a', 'sd as b', '1sd as c')
            ->where([
                'var' => $var,
                'acuan' => $umur,
                'jk' => $jk,
                'jenis_tbl' => 3,
            ])->get();
        foreach ($tbumedian as $data) {
            $a = $data->a;
            $b = $data->b;
            $c = $data->c;
        }

        if ($tb < $b) {
            $tbu = ($tb - $b) / ($b - $a);
        } elseif ($tb > $b) {
            $tbu = ($tb - $b) / ($c - $b);
        }

        $tbuData[] = [
            'bb' => $bb,
            'tb' => $tb,
            'bln' => $umur,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'tbu' => $tbu
        ];
    }


    return $tbuData;
}

function getBB_TB($x)
{
    $bbTbData = [];
    foreach ($x as $key => $data) {
        $posisi = $data->posisi;
        $bb = $data->bb;
        $tb = $data->tb;
        $jk = $data->jk;
        $umur = $data->bln;
        $var = $umur <= 24 ? 1 : 2;
        if ($umur < 24 && $posisi == "H") {
            $tb += 0.7;
        } elseif ($umur >= 24 && $posisi == "L") {
            $tb -= 0.7;
        }
        $tinggi = round($tb);
        $bbtbmedian = DB::table('z_score')
            ->select('id', 'm1sd as a', 'sd as b', '1sd as c')
            ->where([
                'var' => $var,
                'acuan' => $tinggi,
                'jk' => $jk,
                'jenis_tbl' => 4,
            ])->get();

        foreach ($bbtbmedian as $data) {
            $a = $data->a;
            $b = $data->b;
            $c = $data->c;
        }
        if ($bb < $b) {
            $bbtb = ($bb - $b) / ($b - $a);
        } elseif ($bb > $b) {
            $bbtb = ($bb - $b) / ($c - $b);
        }

        $bbTbData[] = [
            'bb' => $bb,
            'tb' => $tb,
            'bln' => $umur,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'bbtb' => $bbtb
        ];
    }

    return $bbTbData;
}

function fuzzyNaik($x, $a, $b)
{
    $a = $a;
    $b = $b;
    $x = $x;
    $hasil = '';
    if ($x <= $a) {
        $hasil = 0;
    } elseif ($x >= $b) {
        $hasil = 1;
    } else {
        $hasil = ($x - $a) / ($b - $a);
    }

    return $hasil;
}

function fuzzyTurun($x, $a, $b)
{
    $a = $a;
    $b = $b;
    $x = $x;
    $hasil = '';
    if ($x >= $b) {
        $hasil = 0;
    } elseif ($x >= $a && $x <= $b) {
        $hasil = ($b - $x) / ($b - $a);
    } else {
        $hasil = 1;
    }

    return $hasil;
}

function fuzzySegitiga($x, $a, $b, $c)
{
    $a = $a;
    $b = $b;
    $c = $c;
    $x = $x;
    $hasil = '';
    if ($x <= $a || $x >= $c) {
        $hasil = 0;
    } elseif ($x <= $b && $x >= $a) {
        $hasil = ($x - $a) / ($b - $a);
    } elseif ($x >= $b && $x <= $c) {
        $hasil = ($c - $x) / ($c - $b);
    }

    return $hasil;
}

function fuzzyTrapesium($x, $a, $b, $c, $d)
{
    $a = $a;
    $b = $b;
    $c = $c;
    $d = $d;
    $x = $x;
    $hasil = '';

    if ($x <= $a) {
        $hasil = 0;
    } elseif ($x >= $a || $x <= $b) {
        $hasil = ($x - $a) / ($b - $a);
    } elseif ($x >= $b && $x <= $c) {
        $hasil = 1;
    } elseif ($x >= $c && $x <= $d) {
        $hasil = ($d - $x) / ($d - $c);
    } elseif ($x >= $d) {
        $hasil = 0;
    }

    return $hasil;
}

function fuzzyBB_U($x, $y)
{
    $bbu = $x;
    $result = [];
    $dataResults = [];
    foreach ($y as $key => $data) {
        $name = $data->name;
        $a = $data->a;
        $b = $data->b;
        $c = $data->c;
        $d = $data->d;
        $type = $data->type;

        $result[$key] = [
            'name' => $name,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'type' => $type
        ];
    }
    
    //Berat Badan Sangat Kurang
    if ($result[0]['type'] == 1) {
        $BBSK = fuzzyNaik($bbu, $result[0]['a'], $result[0]['b']);
    } elseif ($result[0]['type'] == 2) {
        $BBSK = fuzzyTurun($bbu, $result[0]['a'], $result[0]['b']);
    } elseif ($result[0]['type'] == 3) {
        $BBSK =  fuzzySegitiga($bbu, $result[0]['a'], $result[0]['b'], $result[0]['c']);
    } elseif ($result[0]['type'] == 4) {
        $BBSK =  fuzzyTrapesium($bbu, $result[0]['a'], $result[0]['b'], $result[0]['c'], $result[0]['d']);
    }

    //Berat Badan Kurang
    if ($result[1]['type'] == 1) {
        $BBK = fuzzyNaik($bbu, $result[1]['a'], $result[1]['b']);
    } elseif ($result[1]['type'] == 2) {
        $BBK = fuzzyTurun($bbu, $result[1]['a'], $result[1]['b']);
    } elseif ($result[1]['type'] == 3) {
        $BBK =  fuzzySegitiga($bbu, $result[1]['a'], $result[1]['b'], $result[1]['c']);
    } elseif ($result[1]['type'] == 4) {
        $BBK =  fuzzyTrapesium($bbu, $result[1]['a'], $result[1]['b'], $result[1]['c'], $result[1]['d']);
    }

    //Berat Badan Normal
    if ($result[2]['type'] == 1) {
        $BBN = fuzzyNaik($bbu, $result[2]['a'], $result[2]['b']);
    } elseif ($result[2]['type'] == 2) {
        $BBN = fuzzyTurun($bbu, $result[2]['a'], $result[2]['b']);
    } elseif ($result[2]['type'] == 3) {
        $BBN =  fuzzySegitiga($bbu, $result[2]['a'], $result[2]['b'], $result[2]['c']);
    } elseif ($result[2]['type'] == 4) {
        $BBN =  fuzzyTrapesium($bbu, $result[2]['a'], $result[2]['b'], $result[2]['c'], $result[2]['d']);
    }

    //Risiko Berat Badan Lebih
    if ($result[3]['type'] == 1) {
        $RBBL = fuzzyNaik($bbu, $result[3]['a'], $result[3]['b']);
    } elseif ($result[3]['type'] == 2) {
        $RBBL = fuzzyTurun($bbu, $result[3]['a'], $result[3]['b']);
    } elseif ($result[3]['type'] == 3) {
        $RBBL =  fuzzySegitiga($bbu, $result[3]['a'], $result[3]['b'], $result[3]['c']);
    } elseif ($result[3]['type'] == 4) {
        $RBBL =  fuzzyTrapesium($bbu, $result[3]['a'], $result[3]['b'], $result[3]['c'], $result[3]['d']);
    }

    $dataResults = ['BBSK' => $BBSK, 'BBK' => $BBK, 'BBN' => $BBN, 'RBBL' => $RBBL];
    return $dataResults;
}

function fuzzyTB_U($x, $y)
{
    $tbu = $x;
    $result = [];
    $dataResults = [];
    foreach ($y as $key => $data) {
        $name = $data->name;
        $a = $data->a;
        $b = $data->b;
        $c = $data->c;
        $d = $data->d;
        $type = $data->type;

        $result[$key] = [
            'name' => $name,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'type' => $type
        ];
    }
    //Sangat Pendek
    if ($result[0]['type'] == 1) {
        $SP = fuzzyNaik($tbu, $result[0]['a'], $result[0]['b']);
    } elseif ($result[0]['type'] == 2) {
        $SP = fuzzyTurun($tbu, $result[0]['a'], $result[0]['b']);
    } elseif ($result[0]['type'] == 3) {
        $SP =  fuzzySegitiga($tbu, $result[0]['a'], $result[0]['b'], $result[0]['c']);
    } elseif ($result[0]['type'] == 4) {
        $SP =  fuzzyTrapesium($tbu, $result[0]['a'], $result[0]['b'], $result[0]['c'], $result[0]['d']);
    }
    //Pendek
    if ($result[1]['type'] == 1) {
        $P = fuzzyNaik($tbu, $result[1]['a'], $result[1]['b']);
    } elseif ($result[1]['type'] == 2) {
        $P = fuzzyTurun($tbu, $result[1]['a'], $result[1]['b']);
    } elseif ($result[1]['type'] == 3) {
        $P =  fuzzySegitiga($tbu, $result[1]['a'], $result[1]['b'], $result[1]['c']);
    } elseif ($result[1]['type'] == 4) {
        $P =  fuzzyTrapesium($tbu, $result[1]['a'], $result[1]['b'], $result[1]['c'], $result[1]['d']);
    }
    //Normal
    if ($result[2]['type'] == 1) {
        $N = fuzzyNaik($tbu, $result[2]['a'], $result[2]['b']);
    } elseif ($result[2]['type'] == 2) {
        $N = fuzzyTurun($tbu, $result[2]['a'], $result[2]['b']);
    } elseif ($result[2]['type'] == 3) {
        $N =  fuzzySegitiga($tbu, $result[2]['a'], $result[2]['b'], $result[2]['c']);
    } elseif ($result[2]['type'] == 4) {
        $N =  fuzzyTrapesium($tbu, $result[2]['a'], $result[2]['b'], $result[2]['c'], $result[2]['d']);
    }
    //Tinggi
    if ($result[3]['type'] == 1) {
        $T = fuzzyNaik($tbu, $result[3]['a'], $result[3]['b']);
    } elseif ($result[3]['type'] == 2) {
        $T = fuzzyTurun($tbu, $result[3]['a'], $result[3]['b']);
    } elseif ($result[3]['type'] == 3) {
        $T =  fuzzySegitiga($tbu, $result[3]['a'], $result[3]['b'], $result[3]['c']);
    } elseif ($result[3]['type'] == 4) {
        $T =  fuzzyTrapesium($tbu, $result[3]['a'], $result[3]['b'], $result[3]['c'], $result[3]['d']);
    }

    $dataResults = ['SP' => $SP, 'P' => $P, 'N' => $N, 'T' => $T];
    return $dataResults;
}

function fuzzyBB_TB($x, $y)
{
    $bb = $x;
    $result = [];
    $dataResults = [];
    foreach ($y as $key => $data) {
        $name = $data->name;
        $a = $data->a;
        $b = $data->b;
        $c = $data->c;
        $d = $data->d;
        $type = $data->type;

        $result[$key] = [
            'name' => $name,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'type' => $type
        ];
    }
    //Gizi Buruk
    if ($result[0]['type'] == 1) {
        $GBK = fuzzyNaik($bb, $result[0]['a'], $result[0]['b']);
    } elseif ($result[0]['type'] == 2) {
        $GBK = fuzzyTurun($bb, $result[0]['a'], $result[0]['b']);
    } elseif ($result[0]['type'] == 3) {
        $GBK =  fuzzySegitiga($bb, $result[0]['a'], $result[0]['b'], $result[0]['c']);
    } elseif ($result[0]['type'] == 4) {
        $GBK =  fuzzyTrapesium($bb, $result[0]['a'], $result[0]['b'], $result[0]['c'], $result[0]['d']);
    }
    //Gizi Kurang
    if ($result[1]['type'] == 1) {
        $GK = fuzzyNaik($bb, $result[1]['a'], $result[1]['b']);
    } elseif ($result[1]['type'] == 2) {
        $GK = fuzzyTurun($bb, $result[1]['a'], $result[1]['b']);
    } elseif ($result[1]['type'] == 3) {
        $GK =  fuzzySegitiga($bb, $result[1]['a'], $result[1]['b'], $result[1]['c']);
    } elseif ($result[1]['type'] == 4) {
        $GK =  fuzzyTrapesium($bb, $result[1]['a'], $result[1]['b'], $result[1]['c'], $result[1]['d']);
    }
    //Gizi Baik
    if ($result[2]['type'] == 1) {
        $GB = fuzzyNaik($bb, $result[2]['a'], $result[2]['b']);
    } elseif ($result[2]['type'] == 2) {
        $GB = fuzzyTurun($bb, $result[2]['a'], $result[2]['b']);
    } elseif ($result[2]['type'] == 3) {
        $GB =  fuzzySegitiga($bb, $result[2]['a'], $result[2]['b'], $result[2]['c']);
    } elseif ($result[2]['type'] == 4) {
        $GB =  fuzzyTrapesium($bb, $result[2]['a'], $result[2]['b'], $result[2]['c'], $result[2]['d']);
    }
    //Berisiko Gizi Lebih
    if ($result[3]['type'] == 1) {
        $BGL = fuzzyNaik($bb, $result[3]['a'], $result[3]['b']);
    } elseif ($result[3]['type'] == 2) {
        $BGL = fuzzyTurun($bb, $result[3]['a'], $result[3]['b']);
    } elseif ($result[3]['type'] == 3) {
        $BGL =  fuzzySegitiga($bb, $result[3]['a'], $result[3]['b'], $result[3]['c']);
    } elseif ($result[3]['type'] == 4) {
        $BGL =  fuzzyTrapesium($bb, $result[3]['a'], $result[3]['b'], $result[3]['c'], $result[3]['d']);
    }
    //Gizi Lebih
    if ($result[4]['type'] == 1) {
        $GL = fuzzyNaik($bb, $result[4]['a'], $result[4]['b']);
    } elseif ($result[4]['type'] == 2) {
        $GL = fuzzyTurun($bb, $result[4]['a'], $result[4]['b']);
    } elseif ($result[4]['type'] == 3) {
        $GL =  fuzzySegitiga($bb, $result[4]['a'], $result[4]['b'], $result[4]['c']);
    } elseif ($result[4]['type'] == 4) {
        $GL =  fuzzyTrapesium($bb, $result[4]['a'], $result[4]['b'], $result[4]['c'], $result[4]['d']);
    }
    //Obesitas
    if ($result[5]['type'] == 1) {
        $O = fuzzyNaik($bb, $result[5]['a'], $result[5]['b']);
    } elseif ($result[5]['type'] == 2) {
        $O = fuzzyTurun($bb, $result[5]['a'], $result[5]['b']);
    } elseif ($result[5]['type'] == 3) {
        $O =  fuzzySegitiga($bb, $result[5]['a'], $result[5]['b'], $result[5]['c']);
    } elseif ($result[5]['type'] == 4) {
        $O =  fuzzyTrapesium($bb, $result[5]['a'], $result[5]['b'], $result[5]['c'], $result[5]['d']);
    }

    $dataResults = ['GBK' => $GBK, 'GK' => $GK, 'GB' => $GB, 'BGL' => $BGL, 'GL' => $GL, 'O' => $O];
    return $dataResults;
}

function fuzzyimt_u($x, $y)
{
    $imt = $x;
    $result = [];
    $dataResults = [];
    foreach ($y as $key => $data) {
        $name = $data->name;
        $a = $data->a;
        $b = $data->b;
        $c = $data->c;
        $d = $data->d;
        $type = $data->type;

        $result[$key] = [
            'name' => $name,
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'type' => $type
        ];
    }
    //Gizi Buruk
    if ($result[0]['type'] == 1) {
        $GBK = fuzzyNaik($imt, $result[0]['a'], $result[0]['b']);
    } elseif ($result[0]['type'] == 2) {
        $GBK = fuzzyTurun($imt, $result[0]['a'], $result[0]['b']);
    } elseif ($result[0]['type'] == 3) {
        $GBK =  fuzzySegitiga($imt, $result[0]['a'], $result[0]['b'], $result[0]['c']);
    } elseif ($result[0]['type'] == 4) {
        $GBK =  fuzzyTrapesium($imt, $result[0]['a'], $result[0]['b'], $result[0]['c'], $result[0]['d']);
    }
    //Gizi Kurang
    if ($result[1]['type'] == 1) {
        $GK = fuzzyNaik($imt, $result[1]['a'], $result[1]['b']);
    } elseif ($result[1]['type'] == 2) {
        $GK = fuzzyTurun($imt, $result[1]['a'], $result[1]['b']);
    } elseif ($result[1]['type'] == 3) {
        $GK =  fuzzySegitiga($imt, $result[1]['a'], $result[1]['b'], $result[1]['c']);
    } elseif ($result[1]['type'] == 4) {
        $GK =  fuzzyTrapesium($imt, $result[1]['a'], $result[1]['b'], $result[1]['c'], $result[1]['d']);
    }
    //Gizi Baik
    if ($result[2]['type'] == 1) {
        $GB = fuzzyNaik($imt, $result[2]['a'], $result[2]['b']);
    } elseif ($result[2]['type'] == 2) {
        $GB = fuzzyTurun($imt, $result[2]['a'], $result[2]['b']);
    } elseif ($result[2]['type'] == 3) {
        $GB =  fuzzySegitiga($imt, $result[2]['a'], $result[2]['b'], $result[2]['c']);
    } elseif ($result[2]['type'] == 4) {
        $GB =  fuzzyTrapesium($imt, $result[2]['a'], $result[2]['b'], $result[2]['c'], $result[2]['d']);
    }
    //Berisiko Gizi Lebih
    if ($result[3]['type'] == 1) {
        $BGL = fuzzyNaik($imt, $result[3]['a'], $result[3]['b']);
    } elseif ($result[3]['type'] == 2) {
        $BGL = fuzzyTurun($imt, $result[3]['a'], $result[3]['b']);
    } elseif ($result[3]['type'] == 3) {
        $BGL =  fuzzySegitiga($imt, $result[3]['a'], $result[3]['b'], $result[3]['c']);
    } elseif ($result[3]['type'] == 4) {
        $BGL =  fuzzyTrapesium($imt, $result[3]['a'], $result[3]['b'], $result[3]['c'], $result[3]['d']);
    }
    //Gizi Lebih
    if ($result[4]['type'] == 1) {
        $GL = fuzzyNaik($imt, $result[4]['a'], $result[4]['b']);
    } elseif ($result[4]['type'] == 2) {
        $GL = fuzzyTurun($imt, $result[4]['a'], $result[4]['b']);
    } elseif ($result[4]['type'] == 3) {
        $GL =  fuzzySegitiga($imt, $result[4]['a'], $result[4]['b'], $result[4]['c']);
    } elseif ($result[4]['type'] == 4) {
        $GL =  fuzzyTrapesium($imt, $result[4]['a'], $result[4]['b'], $result[4]['c'], $result[4]['d']);
    }
    //Obesitas
    if ($result[5]['type'] == 1) {
        $O = fuzzyNaik($imt, $result[5]['a'], $result[5]['b']);
    } elseif ($result[5]['type'] == 2) {
        $O = fuzzyTurun($imt, $result[5]['a'], $result[5]['b']);
    } elseif ($result[5]['type'] == 3) {
        $O =  fuzzySegitiga($imt, $result[5]['a'], $result[5]['b'], $result[5]['c']);
    } elseif ($result[5]['type'] == 4) {
        $O =  fuzzyTrapesium($imt, $result[5]['a'], $result[5]['b'], $result[5]['c'], $result[5]['d']);
    }

    $dataResults = ['GBK' => $GBK, 'GK' => $GK, 'GB' => $GB, 'BGL' => $BGL, 'GL' => $GL, 'O' => $O];
    return $dataResults;
}
