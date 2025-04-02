<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Circuit;
use App\Models\Lap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LapController extends Controller
{
    public function index(Request $request) {
        // SELECT laps.*
        // FROM laps JOIN (
        //     SELECT id_user, MIN(time) AS bestTime
        //     FROM laps
        //     WHERE isValid = 1
        //     GROUP BY id_user
        // ) best
        // ON laps.id_user = best.id_user AND laps.time = best.bestTime;

        $lapTable = (new Lap)->getTable();
        $bestLaps = Lap::join(
            \DB::raw("
                (SELECT id_user, MIN(time) as betTime FROM $lapTable
                WHERE isValid = 1 GROUP BY id_user) as bestUsersLap
            "),
            function ($join) use(&$lapTable) {
                $join->on("$lapTable.id_user", '=', 'bestUsersLap.id_user')
                     ->on("$lapTable.time", '=', 'bestUsersLap.betTime');
            }
        )->get();

        return $bestLaps;
    }

    public function store (Request $request) {
        $circuit = Circuit::with('coords') // TODO: tornar isso aqui dinâmico
            ->where('id', '1')
            ->first();

        foreach ($request->laps as $lap) {

            Lap::create([
                'isValid' => filter_var($lap['isValid'], FILTER_VALIDATE_BOOLEAN), // Transformar string em boolean
                'time' => $lap['time'],
                'distance_traveled' => $lap['distance_traveled'],
                'avg_speed' => $lap['avg_speed'],
                'top_speed' => $lap['top_speed'],
                'avg_accuracy' => $lap['avg_accuracy'],
                'coords_count' => $lap['coords_count'],
                'id_user' => Auth::user()->id,
                'id_circuit' => $circuit->id
            ]);
        }

    }
}
