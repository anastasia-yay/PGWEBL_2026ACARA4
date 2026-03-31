<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    protected $points;

    public function __construct()
    {
        $this->points = new PointsModel();
    }

    public function store(Request $request)
    {
        //Validasi input
        $request->validate(
            [
                'geometry_point' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string'
            ],
            [
                'geometry_point.required' => 'Field geometry point harus diisi.',
                'name.required' => 'Field nama harus diisi.',
                'name.string' => 'Field nama harus berupa string.',
                'name.max' => 'Field nama tidak boleh lebih dari 255 karakter.',
                'description.required' => 'Field description harus diisi.',
            ]);

        $data = [
            'geom' => $request->geometry_point,
            'name' => $request->name,
            'description' => $request->description
        ];
        //simpan ke database
        if (!$this->points->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal
            menyimpan data poin.');
        }
        //balik ke halaman peta
        return redirect()->route('peta')->with('success', 'Data poin
        berhasil disimpan.');
    }
}


