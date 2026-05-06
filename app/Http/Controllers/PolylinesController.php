<?php

namespace App\Http\Controllers;

use App\Models\polylinesModel;
use Illuminate\Http\Request;

class PolylinesController extends Controller
{
    public function __construct()
    {
        $this->polylines = new polylinesModel();
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validasi input
        $request->validate(
            [
                'geometry_polyline' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'geometry_polyline.required' => 'Field geometry point harus diisi.',
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
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_polyline,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];
        //simpan ke database
        if (!$this->polylines->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal
            menyimpan data polyline.');
        }
        //balik ke halaman peta
        return redirect()->route('peta')->with('success', 'Data polyline
        berhasil disimpan.');
    }

    public function destroy(string $id)
    {
        //Mencari gambar di storage
        $image = $this->polylines->find($id)->image;

        //Hapus data dari database
        if (!$this->polylines->destroy($id)) {
            return redirect()->route('peta')->with('error', 'Gagal menghapus data polyline');
            }

        //Hapus file gambar jika ada
        if ($image != null) {
            if (file_exists('storage/images/' . $image)) {
            unlink('storage/images/' . $image);
            }
        }

        return redirect()->route('peta')->with('success', 'Data line berhasil dihapus');
    }

    public function geojson()
    {
        $polylines = $this->polylines->all();

        $features = [];

        foreach ($polylines as $p) {
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
