<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'moisture' => 'required|integer',
            'humidity' => 'required|numeric',
            'temperature' => 'required|numeric',
        ]);

        SensorData::create([
            'moisture' => $validated['moisture'],
            'humidity' => $validated['humidity'],
            'temperature' => $validated['temperature'],
            'recorded_at' => now(),
        ]);

        return response()->json(['message' => 'Data received successfully'], 200);
    } catch (\Exception $e) {
        // Log the exception message for debugging
        \Log::error('Failed to store sensor data: ' . $e->getMessage());

        return response()->json(['message' => 'Failed to store data'], 500);
    }
}
}