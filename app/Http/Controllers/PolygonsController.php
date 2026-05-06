<?php

namespace App\Http\Controllers;

use App\Models\polygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    //Fungsi untuk mnengoneksikan model ke controllernya
    public function __construct()
    {
        $this->polygons = new polygonsModel();
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
                'geometry_polygon' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ],
            [
                'geometry_polygon.required' => 'Field geometry point harus diisi.',
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
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];
        //simpan ke database
        if (!$this->polygons->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal
            menyimpan data polygon.');
        }
        //balik ke halaman peta
        return redirect()->route('peta')->with('success', 'Data polygon
        berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Mencari gambar di storage
        $image = $this->polygons->find($id)->image;

        //Hapus data dari database
        if (!$this->polygons->destroy($id)) {
            return redirect()->route('peta')->with('error', 'Gagal menghapus data polygon');
            }

        //Hapus file gambar jika ada
        if ($image != null) {
    if (file_exists('storage/images/' . $image)) {
        unlink('storage/images/' . $image);
    }
}

return redirect()->route('peta')->with('success', 'Data polygon berhasil dihapus');
    }

    public function geojson()
    {
        $polygons = $this->polygons->all();

        $features = [];

        foreach ($polygons as $p) {
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
