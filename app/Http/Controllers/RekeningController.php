<?php

namespace App\Http\Controllers;

use App\Models\rekening;
use Illuminate\Http\Request;

/*
|
| Setiap return view wajib mereturn variable $title untuk memberi judul pada halaman
| e.g
| $data = ["title" => "Master"]
|
*/


class RekeningController extends Controller
{
    //
    public function index()
    {
        $data = [
            "title" => "Rekening",
            "rekenings" => rekening::all()
        ];

        return view("rekening", $data);
    }

    public function store(Request $request)
    {
        $rekening = rekening::create([
            "kode_rekening" => $request->kode_rekening,
            "nama_rekening" => $request->nama_rekening
        ]);

        if ($rekening) {
            return redirect("rekening")->with("success", "Rekening Berhasil ditambahkan");
        } else {
            return redirect("rekening")->with("error", "Rekening Gagal ditambahkan");
        }
    }

    public function update(Request $request)
    {
        // return $request;

        $rekening = rekening::find($request->id_rekening);
        $rekening->nama_rekening = $request->nama_rekening;
        $rekening->kode_rekening = $request->kode_rekening;
        $rekening->save();
        if ($rekening) {
            return redirect("rekening")->with("success", "Rekening Berhasil diubah");
        } else {
            return redirect("rekening")->with("error", "Rekening Gagal diubah");
        }
    }
}
