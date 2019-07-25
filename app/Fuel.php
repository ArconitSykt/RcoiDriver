<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Fuel extends Model
{
    public static function last() {
         return response()->json(DB::table('fuels')
         ->orderBy('id','desc')
        ->first());
    }

    public static function create($req) {
        try {
            DB::table('fuels')->insert(
                [
                    'date' => $req->fuel['date'],
                    'start_odd' => $req->fuel['start_odd'],
                    'end_odd' => $req->fuel['end_odd'],
                    'fuel' => $req->fuel['fuel'],
                    'fueling' => $req->fuel['fueling'],
                    'waiting' => $req->fuel['waiting'],
                    'check' => $req->fuel['check']
                ]
            );
            return "success create item";
        } catch (\Throwable $th) {
            return "error: ".$th;
        }
    }

    public static function Excel($req) {
        $month = substr($req, 5, 2);
        $year = substr($req, 0, 4);
        // var_dump($month, $year);
        return DB::table('fuels')
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->get();
   }

   public static function stringMonth($date) {
        $month = substr($date, 5, 2);
        $year = substr($date, 0, 4);

        $arrayMonth=[
            1=>'январь',
            2=>'февраль',
            3=>'март',
            4=>'апрель',
            5=>'май',
            6=>'июнь',
            7=>'июль',
            8=>'август',
            9=>'сентябрь',
            10=>'октябрь',
            11=>'ноябрь',
            12=>'декабрь'
          ];
    return $arrayMonth[(int)$month]." $year года";
   }
}