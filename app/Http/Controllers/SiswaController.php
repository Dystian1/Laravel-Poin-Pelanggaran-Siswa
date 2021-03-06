<?php

namespace App\Http\Controllers;

use App\siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Siswa::count();
        $siswa = array();
        foreach (Siswa::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "nis"               => $p->nis,
                "nama_siswa"        => $p->nama_siswa,
                "kelas"             => $p->kelas,
                "poin"              => $p->poins,
            ];
            array_push($siswa, $item);
        }
        $data["siswa"] = $siswa;
        $data["status"]=1;
        return response($data);
    }

    public function find(Request $request, $limit = 10, $offset = 0)
    {
        $find = $request->find;
        $siswa = Siswa::where("nis","like","%$find%")
        ->orWhere("nama_siswa","like","%$find%")
        ->orWhere("kelas","like","%$find%");
        $data["count"] = $siswa->count();
        $siswas = array();
        foreach ($siswa->skip($offset)->take($limit)->get() as $p) {
          $item = [
            "nis" => $p->nis,
            "nama_siswa" => $p->nama_siswa,
            "kelas" => $p->kelas,
          ];
          array_push($siswas,$item);
        }
        $data["siswa"] = $siswas;
        $data["status"] = 1;
        return response($data);
    }
    public function store(Request $request)
    {
        $siswa = new siswa([
            'nis'         => $request->nis,
            'nama_siswa'  => $request->nama_siswa,
            'kelas'       => $request->kelas,
        ]);
        $siswa->save();
        return response($siswa);
    }

    public function show($id)
    {
        $siswa = Siswa::where('id', $id)->get();
        $dataSiswa = array();
        foreach ($siswa as $p) {
            $item = [
                "id"           => $p->id,
                "nis"          => $p->nis,
                "nama_siswa"   => $p->nama_siswa,
                "kelas"        => $p->kelas,
                "poin"         => $p->poins,
            ];
            array_push($dataSiswa, $item);
      }
      $data["dataSiswa"] = $dataSiswa;
      $data["status"] = 1;
      return response($data);
    }

    public function update($id, Request $request)
    {
        $siswa = Siswa::where('id', $id)->first();

        $siswa->nis           = $request->nis;
        $siswa->nama_siswa    = $request->nama_siswa;
        $siswa->kelas         = $request->kelas;
        $siswa->updated_at    = now()->timestamp;
        $siswa->save();

        return response($siswa);
    }

    public function destroy($id)
    {
        $siswa = Siswa::where('id', $id)->first();
        $siswa->delete();

        return response()->json([
            'status'  => '1',
            'message' => 'Delete Data Berhasil'
        ]);
    }
}
