<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Post;
use App\User;
use App\Monster;
use App\Game;
use App\Config;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeConfig(Request $request){

        $data=$request->json()->all();
        $user_id = $data['user_id'];
        $count=Config::where('user_id', '=', $user_id)->count();
        if($count>0){
            $deletedRows = Config::where('user_id', '=', $user_id)->delete();
        }
        $configs = DB::table('configs')->where('user_id', '=', $user_id)->get();
        Config::create($request->json()->all());
        return response()->json(['success' => true]);

    }

    /**
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function listConfigs($user_id){
        $configs = DB::table('configs')->where('user_id', '=', $user_id)->get();
        return response()->json($configs);
    }
}
