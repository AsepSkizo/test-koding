<?php

namespace App\Http\Controllers;

use App\Models\harian;
use App\Models\rekening;
use App\Models\target;
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

    public function delete(Request $request)
    {
        // return $request;
        $countTarget = target::where("rekening_id", $request->id)->count();
        $countHarian = harian::where("rekening_id", $request->id)->count();

        if ($countHarian > 0 || $countTarget > 0) {
            return redirect("rekening")->with("error", "Rekening Gagal dihapus");
        }
        $rekening = rekening::find($request->id);
        $rekening->delete();
        if ($rekening) {
            return redirect("rekening")->with("success", "Rekening Berhasil dihapus");
        } else {
            return redirect("rekening")->with("error", "Rekening Gagal dihapus");
        }
    }

    public function search(Request $request)
    {
        $search = $request->input("query");

        $rekenings = rekening::query()->where("kode_rekening", "LIKE", "%{$search}%")->orWhere("nama_rekening", "LIKE", "%{$search}%")->get();

        $data = [
            "title" => "Target",
            "rekenings" => $rekenings,
            "query" => $search
        ];
        return view("rekening", $data);
    }
}
