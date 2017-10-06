<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeController extends Controller
{

    /**
     *
     */
    public function index(){

        $time = Carbon::now();
        $dateTime = $time->toDateTimeString();
        return response()->json([
            'timestamp' => $dateTime
        ]);
    }
}
