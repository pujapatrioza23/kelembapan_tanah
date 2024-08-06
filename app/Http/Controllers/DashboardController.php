<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data terbaru dari database
        $data = SensorData::orderBy('recorded_at', 'desc')->get();

        // Kirim data ke tampilan
        return view('dashboard', ['data' => $data]);
    }
}
