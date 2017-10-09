<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Monster;
use App\Game;

class UtilityController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function truncateAll(Request $request){

        DB::table('posts')->truncate();
        DB::table('configs')->truncate();
        DB::table('games')->truncate();

        return response()->json(['success' => true]);
    }
}
