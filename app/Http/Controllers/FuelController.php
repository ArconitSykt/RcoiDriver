<?php

namespace App\Http\Controllers;
use App\Fuel;
use Illuminate\Http\Request;

class FuelController extends Controller
{
    public function all() {
        return Fuel::getAll();
    }

    public function last() {
        return Fuel::last();
    }

    public function createFuel(Request $request) {
        return Fuel::createFuel($request);
    }

    public function updateFuel(Request $request)
    {
        return Fuel::updateFuel($request->fuel);
    }
    
    public function fuel($date)
    {
        return view('fuel', [
            'data' => Fuel::Excel($date),
            'date' => $date,
            'month' => Fuel::stringMonth($date)
        ]);
    }
}