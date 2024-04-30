<?php

namespace App\Http\Controllers;

use App\Models\harian;
use App\Models\periode;
use App\Models\rekening;
use App\Models\target;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class LaporanController extends Controller
{
    public function index()
    {
        $data = [
            "title" => "Laporan",
            "periodes" => periode::all()
        ];
        return view("laporan", $data);
    }

    /*
    | return data
    | title => judul halaman
    | datas => data rekening dan jumlah pajak
    | masa_berlaku_awal => tgl awal periode
    | masa_berlaku_akhir => tgl akhir periode
    | tahun => tahun periode berlaku


    | nb : setelah melakukan pengulangan, $i diubah menjadi = 0
    */
    public function detail($idPeriode)
    {
        $periode = periode::find($idPeriode);

        if ($periode == null) {
            return redirect("laporan")->with("error", "Data tidak ditemukan");
        }

        $masaBerlakuAwal = $periode->masa_berlaku_awal;
        $masaBerlakuAkhir = $periode->masa_berlaku_akhir;

        $targetTerkait = target::where("periode_id", $idPeriode)->get();

        $dataUang = [];
        $i = 0;

        // Mendata semua uang yg terkumpul bulan ini
        $tanggal_awal_bulan_ini = date('Y-m-01');
        $tanggal_akhir_bulan_ini = date('Y-m-t');

        foreach ($targetTerkait as $target) {
            $harians = harian::where("rekening_id", $target->rekening_id)->whereBetween("tanggal", [$masaBerlakuAwal, $masaBerlakuAkhir])->whereBetween("tanggal", [$tanggal_awal_bulan_ini, $tanggal_akhir_bulan_ini])->get();
            $dataUang[$i] = [
                "rekening" => rekening::find($target->rekening_id),
                "target" => $target->target,
                "jumlah_bulan_ini" => 0,
                "jumlah_bulan_lalu" => 0,
                "jumlah" => 0
            ];
            foreach ($harians as $harian) {
                $dataUang[$i]["jumlah_bulan_ini"] += $harian->jumlah;
            }
            $i++;
        }

        $i = 0;

        // Mendata semua uang yang terkumpul
        foreach ($targetTerkait as $target) {
            $harians = harian::where("rekening_id", $target->rekening_id)->whereBetween("tanggal", [$masaBerlakuAwal, $masaBerlakuAkhir])->get();
            foreach ($harians as $harian) {
                $dataUang[$i]["jumlah"] += $harian->jumlah;
            }
            $i++;
        }
        $data = [
            "title" => "Laporan",
            "datas" => $dataUang,
            "masa_berlaku_awal" => $masaBerlakuAwal,
            "masa_berlaku_akhir" => $masaBerlakuAkhir,
            "id_periode" => $idPeriode,
            "tahun" => date("Y", strtotime($masaBerlakuAwal))
        ];
        return view("detail_laporan", $data);
    }

    public function detail_search(Request $request, $idPeriode)
    {
        $periode = periode::find($idPeriode);
        $input_tanggal_awal = $request->awal;
        $input_tanggal_akhir = $request->akhir;
        $via = $request->via;
        $masa_periode_awal = $periode->masa_berlaku_awal;
        $masa_periode_akhir = $periode->masa_berlaku_akhir;

        if (($input_tanggal_awal != null && $input_tanggal_akhir == null) || ($input_tanggal_awal == null && $input_tanggal_akhir != null)) {
            return redirect("laporan/" . $request->periode)->with("error", "Data tidak ditemukan");
        }
        if ($input_tanggal_awal > $input_tanggal_akhir) {
            return redirect("laporan/" . $request->periode)->with("error", "Data tidak ditemukan");
        }
        if (
            $input_tanggal_awal < $periode->masa_berlaku_awal || $input_tanggal_awal > $periode->masa_berlaku_akhir ||
            $input_tanggal_akhir < $periode->masa_berlaku_awal || $input_tanggal_akhir > $periode->masa_berlaku_akhir
        ) {
            return redirect("laporan/" . $request->periode)->with("error", "Data tidak ditemukan");
        }

        if ($input_tanggal_awal == null && $input_tanggal_akhir == null && $via == null) {
            return redirect("laporan/" . $request->periode)->with("error", "Data tidak ditemukan");
        }


        $targetTerkait = target::where("periode_id", $idPeriode)->get();

        // Jika filter tanggal dan via bayar tidak kosong 
        if ($input_tanggal_awal != null && $input_tanggal_akhir != null && $via != null) {
            $i = 0;
            // Mendata semua uang yg terkumpul bulan ini
            $tanggal_awal_bulan_ini = $input_tanggal_awal;
            $tanggal_akhir_bulan_ini = $input_tanggal_akhir;

            $tahun = date("Y", strtotime($tanggal_awal_bulan_ini));

            foreach ($targetTerkait as $target) {
                $harians = harian::where("rekening_id", $target->rekening_id)->where("via", $via)->whereBetween("tanggal", [$masa_periode_awal, $masa_periode_akhir])->whereBetween("tanggal", [$tanggal_awal_bulan_ini, $tanggal_akhir_bulan_ini])->get();
                $dataUang[$i] = [
                    "rekening" => rekening::find($target->rekening_id),
                    "target" => $target->target,
                    "jumlah_bulan_ini" => 0,
                    "jumlah_bulan_lalu" => 0,
                    "jumlah" => 0
                ];
                foreach ($harians as $harian) {
                    $dataUang[$i]["jumlah_bulan_ini"] += $harian->jumlah;
                    $dataUang[$i]["jumlah"] += $harian->jumlah;
                }
                $i++;
            }

            // Mendata semua uang yang terkumpul bulan lalu
            $i = 0;
            $tanggal_akhir_bulan_lalu = date("Y-m-d", strtotime("-1 day", strtotime($tanggal_awal_bulan_ini)));
            $tanggal_awal_tahun = $tahun . "01-01";
            foreach ($targetTerkait as $target) {
                $harians = harian::where("rekening_id", $target->rekening_id)->where("via", $via)->whereBetween("tanggal", [$masa_periode_awal, $masa_periode_akhir])->whereBetween("tanggal", [$tanggal_awal_tahun, $tanggal_akhir_bulan_lalu])->get();
                foreach ($harians as $harian) {
                    $dataUang[$i]["jumlah_bulan_lalu"] += $harian->jumlah;
                    $dataUang[$i]["jumlah"] += $harian->jumlah;
                }
                $i++;
            }
            $data = [
                "title" => "Laporan",
                "datas" => $dataUang,
                "masa_berlaku_awal" => $input_tanggal_awal,
                "masa_berlaku_akhir" => $input_tanggal_akhir,
                "id_periode" => $idPeriode,
                "tahun" => $tahun
            ];
            if ($via != null) {
                $data["via"] = $via;
            }
            // return $data;
        }

        // JIka filter tanggal diisi dan filter via bayar kosong
        if ($input_tanggal_awal != null && $input_tanggal_akhir != null && $via == null) {
            $i = 0;
            // Mendata semua uang yg terkumpul bulan ini
            $tanggal_awal_bulan_ini = $input_tanggal_awal;
            $tanggal_akhir_bulan_ini = $input_tanggal_akhir;

            $tahun = date("Y", strtotime($tanggal_awal_bulan_ini));


            foreach ($targetTerkait as $target) {
                $harians = harian::where("rekening_id", $target->rekening_id)->whereBetween("tanggal", [$masa_periode_awal, $masa_periode_akhir])->whereBetween("tanggal", [$tanggal_awal_bulan_ini, $tanggal_akhir_bulan_ini])->get();
                $dataUang[$i] = [
                    "rekening" => rekening::find($target->rekening_id),
                    "target" => $target->target,
                    "jumlah_bulan_ini" => 0,
                    "jumlah_bulan_lalu" => 0,
                    "jumlah" => 0
                ];
                foreach ($harians as $harian) {
                    $dataUang[$i]["jumlah_bulan_ini"] += $harian->jumlah;
                    $dataUang[$i]["jumlah"] += $harian->jumlah;
                }
                $i++;
            }

            // Mendata semua uang yang terkumpul bulan lalu
            $i = 0;
            $tanggal_akhir_bulan_lalu = date("Y-m-d", strtotime("-1 day", strtotime($tanggal_awal_bulan_ini)));
            $tanggal_awal_tahun = $tahun . "01-01";
            foreach ($targetTerkait as $target) {
                $harians = harian::where("rekening_id", $target->rekening_id)->whereBetween("tanggal", [$masa_periode_awal, $masa_periode_akhir])->whereBetween("tanggal", [$tanggal_awal_tahun, $tanggal_akhir_bulan_lalu])->get();
                foreach ($harians as $harian) {
                    $dataUang[$i]["jumlah_bulan_lalu"] += $harian->jumlah;
                    $dataUang[$i]["jumlah"] += $harian->jumlah;
                }
                $i++;
            }
            $data = [
                "title" => "Laporan",
                "datas" => $dataUang,
                "masa_berlaku_awal" => $input_tanggal_awal,
                "masa_berlaku_akhir" => $input_tanggal_akhir,
                "id_periode" => $idPeriode,
                "tahun" => $tahun
            ];
        }
        if ($via != null) {
            $data["via"] = $via;
        }
        return view("detail_laporan", $data);
    }
}
