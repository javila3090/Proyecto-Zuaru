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
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function play($user_id)
    {
        $user = new User();
        $monster = new Monster();
        $game = new Game();
        $monster = Monster::inRandomOrder()->first();
        $user = User::find($user_id);
        $monsterDamage = $monster->level;
        $userLevel = $user->level;
        $userDamage = $user->level+1;
        $userLife = $user->life;
        if($monsterDamage == 5){
            $result="El mounstro vence al jugador";
            $userLife -= 1;
            if($userLife== 0){
                $user->life = 4;
                $user->level = 1;
                $user->win = 0;
                $user->save();
            }else {
                $user->life = $userLife;
                $user->save();
            }

            $game->user_id = $user->id;
            $game->monster_id = $monster->id;
            $game->result = $result;
            $game->result_type = 1;

            $game->save();

        }else if($userDamage>$monsterDamage){
            $result="El jugador vence al mounstro";
            $win=$user->win+=1;
            if($user->win==3){
                $level = $user->level +=1;
                $user->level= $level;
                $user->life = $level+3;
                $user->win = 0;
                $user->save();
            }else{
                $user->win = $win;
                $user->save();
            }

            $game->user_id = $user->id;
            $game->monster_id = $monster->id;
            $game->result = $result;
            $game->result_type = 2;

            $game->save();
        }else{
            $result="El mounstro vence al jugador";
            $userLife -= 1;
            if($userLife== 0){
                $user->life = 4;
                $user->level = 1;
                $user->win = 0;
                $user->save();
            }else {
                $user->life = $userLife;
                $user->save();
            }

            $game->user_id = $user->id;
            $game->monster_id = $monster->id;
            $game->result = $result;
            $game->result_type = 1;

            $game->save();
        }
        return response()->json(["Message" => $result]);
    }

    /**
     * @return mixed
     */
    public function leaderBoard(){

        $leaders=User::orderBy('level', 'desc')->get();
        $i=0;
        foreach ($leaders as $leader){
            $i++;
            $array[] = array("userid" => $leader->id, "level" => $leader->level, "rank" => $i);
        }
        return response()->json(['entries'=>$array]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeConfig(Request $request){

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
