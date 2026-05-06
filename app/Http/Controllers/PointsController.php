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
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'geometry_point.required' => 'Field geometry point harus diisi.',
                'name.required' => 'Field nama harus diisi.',
                'name.string' => 'Field nama harus berupa string.',
                'name.max' => 'Field nama tidak boleh lebih dari 255 karakter.',
                'description.required' => 'Field description harus diisi.',
                'image.image' => 'File harus berupa file gambar.',
                'image.mimes' => 'File gambar harus berformat jpeg, png, atau jpg.',
                'image.max' => 'Maksimal ukuran file gambar 2MB.',

            ]);

        //membuat direktori untuk images apabila itu tidak tersedia
        if (!is_dir('storage/images')) {
        mkdir('./storage/images', 0777);
        }

        //get the upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_point,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        //dd($data);

        //simpan ke database
        if (!$this->points->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data poin.');
        }
        //balik ke halaman peta
        return redirect()->route('peta')->with('success', 'Data poin
        berhasil disimpan.');
    }

    public function destroy(string $id)
    {
        //Mencari gambar berdasarkan ID Point
        $image = $this->points->find($id)->image;

        //Hapus data dari database
        if (!$this->points->destroy($id)) {
            return redirect()->route('peta')->with('error', 'Gagal menghapus data point');
            }

        //Hapus file gambar jika ada
        if ($image !=null) {
            //cek apakah file gambar ada sebelum menghapus
            if (file_exists('storage/images/' . $image)) {
                //hapus file gambar
                unlink('storage/images/' . $image);
                }
        }

        //Kembali ke halaman peta
        return redirect()->route('peta')->with('success', 'Data poin berhasil dihapus');

    }

    public function geojson()
    {
        $points = $this->points->all();

        $features = [];

        foreach ($points as $p) {
            $features[] = [
                "type" => "Feature",
                "geometry" => json_decode(\DB::selectOne("SELECT ST_AsGeoJSON('$p->geom') as geo")->geo),
                "properties" => [
                    "id" => $p->id,
                    "name" => $p->name,
                    "description" => $p->description,
                    "image" => $p->image,
                    "created_at" => $p->created_at
                ]
            ];
        }

        return response()->json([
            "type" => "FeatureCollection",
            "features" => $features
        ]);
    }
}


