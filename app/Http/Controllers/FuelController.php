<?php

namespace App\Http\Controllers;
use App\Fuel;
use Illuminate\Http\Request;

class FuelController extends Controller
{
    public function last() {
        return Fuel::last();
    }

    public function create(Request $request) {
        return Fuel::create($request);
    }

    public function fuel($date)
    {
        // var_dump($request);
        // return 0;
        
        return view('fuel', [
            'data' => Fuel::Excel($date),
            'date' => $date,
            'month' => Fuel::stringMonth($date)
        ]);
    }
}