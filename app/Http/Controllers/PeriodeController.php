<?php

namespace App\Http\Controllers;

use App\Models\periode;
use Illuminate\Http\Request;

/*
|
| Setiap return view wajib mereturn variable $title untuk memberi judul pada halaman
| e.g
| $data = ["title" => "Master"]
|
*/



class PeriodeController extends Controller
{
    public function index()
    {
        $data = [
            "title" => "Periode",
            "periodes" => periode::all()
        ];

        return view('periode', $data);
    }

    public function store(Request $request)
    {
        $periode = periode::create([
            "masa_berlaku_awal" => $request->masa_awal,
            "masa_berlaku_akhir" => $request->masa_akhir
        ]);

        if ($periode) {
            return redirect("periode")->with("success", "Periode Berhasil ditambahkan");
        } else {
            return redirect("periode")->with("error", "Periode Gagal ditambahkan");
        }
    }
}
