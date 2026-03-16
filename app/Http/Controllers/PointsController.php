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
        $data = [
            'geom' => $request->geometry_point,
            'name' => $request->name,
            'description' => $request->description
        ];

        $this->points->create($data);

        return redirect()->route('peta');
    }
}


