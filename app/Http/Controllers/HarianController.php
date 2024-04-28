<?php

namespace App\Http\Controllers;

use App\Models\harian;
use App\Models\rekening;
use Illuminate\Http\Request;

class HarianController extends Controller
{
    //

    public function index()
    {
        $data = [
            "title" => "Harian",
            "harians" => harian::with("rekening")->get(),
            "rekenings" => rekening::all()
        ];

        return view("harian", $data);
    }

    public function store(Request $request)
    {
        // return $request;
        if ($request->jumlah <= 0) {
            return redirect("harian")->with("error", "Entry Gagal ditambahkan");
        }

        $harian = harian::create([
            "rekening_id" => $request->rekening,
            "via" => $request->via,
            "tanggal" => $request->tanggal,
            "jumlah" => $request->jumlah
        ]);

        if ($harian) {
            return redirect("harian")->with("success", "Entry Berhasil ditambahkan");
        } else {
            return redirect("harian")->with("error", "Entry Gagal ditambahkan");
        }
    }

    public function update(Request $request)
    {
        // return $request;
        if ($request->jumlah <= 0) {
            return redirect("harian")->with("error", "Entry Gagal ditambahkan");
        }


        $harian = harian::find($request->id);

        $harian->rekening_id = $request->rekening;
        $harian->via = $request->via;
        $harian->tanggal = $request->tanggal;
        $harian->jumlah = $request->jumlah;
        $harian->save();

        if ($harian) {
            return redirect("harian")->with("success", "Entry Berhasil diubah");
        } else {
            return redirect("harian")->with("error", "Entry Gagal diubah");
        }
    }

    public function delete(Request $request)
    {
        // return $request;

        $harian = harian::find($request->id);

        $harian->delete();
        if ($harian) {
            return redirect("harian")->with("success", "Entry Berhasil dihapus");
        } else {
            return redirect("harian")->with("error", "Entry Gagal dihapus");
        }
    }
}
