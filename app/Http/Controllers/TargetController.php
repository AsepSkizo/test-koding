<?php

namespace App\Http\Controllers;

use App\Models\harian;
use App\Models\periode;
use App\Models\rekening;
use App\Models\target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    //

    public function index()
    {
        $data = [
            "title" => "Target",
            "targets" => target::with(["rekening", "periode"])->get(),
            "rekenings" => rekening::all(),
            "periodes" => periode::all()
        ];
        // return $data;
        return view("target", $data);
    }

    public function store(Request $request)
    {
        if ($request->target <= 0) {
            return redirect("target")->with("error", "Target Gagal ditambahkan");
        }


        $target = target::create([
            "rekening_id" => $request->rekening,
            "periode_id" => $request->periode,
            "target" =>  $request->target
        ]);

        if ($target) {
            return redirect("target")->with("success", "Target Berhasil ditambahkan");
        } else {
            return redirect("target")->with("error", "Target Gagal ditambahkan");
        }
    }

    public function update(Request $request)
    {
        if ($request->target <= 0) {
            return redirect("target")->with("error", "Target Gagal diubah");
        }

        $target = target::find($request->idTarget);

        $countRekeningTarget = target::where("rekening_id", $request->rekening)->count();
        $countPeriodeTarget = target::where("periode_id", $request->periode)->count();
        $compareTarget = $target->target == $request->target;

        if ($countPeriodeTarget > 0 && $countRekeningTarget > 0 && $compareTarget > 0) {
            return redirect("target")->with("error", "Target Gagal diubah");
        }


        $target->periode_id = $request->periode;
        $target->rekening_id = $request->rekening;
        $target->target = $request->target;
        $target->save();

        if ($target) {
            return redirect("target")->with("success", "Target Berhasil diubah");
        } else {
            return redirect("target")->with("error", "Target Gagal diubah");
        }
    }

    public function delete(Request $request)
    {
        // return $request;
        $target = target::with(["rekening", "periode"])->where("id", $request->id)->get();
        $countRekeningHarian = harian::where("rekening_id", $target[0]->rekening->id)->count();
        $countPeriodeHarian = harian::whereBetween("tanggal", [$target[0]->periode->masa_berlaku_awal, $target[0]->periode->masa_berlaku_akhir])->count();

        if ($countPeriodeHarian > 0 && $countRekeningHarian > 0) {
            return redirect("target")->with("error", "Target Gagal dihapus");
        }

        $target = target::find($request->id);
        $target->delete();

        if ($target) {
            return redirect("target")->with("success", "Target Berhasil dihapus");
        } else {
            return redirect("target")->with("error", "Target Gagal dihapus");
        }
    }
}
