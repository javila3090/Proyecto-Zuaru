<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Monster;
use App\Game;

class GameController extends Controller
{
    /**
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function play($user_id)
    {
        //Creando objetos para los modelos
        $user = new User();
        $monster = new Monster();
        $game = new Game();

        //Solicitando un mounstro aleatoriamente desde la base de datos
        $monster = Monster::inRandomOrder()->first();

        //Obteniendo datos del usuario y seteando las variables necesarias
        $user = User::find($user_id);
        $monsterDamage = $monster->level;
        $userLevel = $user->level;
        $userDamage = $user->level+1;
        $userLife = $user->life;

        //De acuerdo a tres posibles criterios se obtiene un resultado
        if($monsterDamage == 5){
            $result="El jugador es vencido por un monstruo nivel 5";
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
            //Seteando variables y actualizando datos en la base de datos
            $game->user_id = $user->id;
            $game->monster_id = $monster->id;
            $game->result = $result;
            $game->result_type = 1;

            $game->save();

        }else if($userDamage>=$monsterDamage){
            $result="El jugador vence al monstruo";
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
            //Seteando variables y actualizando datos en la base de datos
            $game->user_id = $user->id;
            $game->monster_id = $monster->id;
            $game->result = $result;
            $game->result_type = 2;

            $game->save();
        }else{
            $result="El jugador es vencido por un monstruo";
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

            //Seteando variables y actualizando datos en la base de datos
            $game->user_id = $user->id;
            $game->monster_id = $monster->id;
            $game->result = $result;
            $game->result_type = 1;

            $game->save();
        }

        return response()->json(["Message" => $result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function leaderBoard(Request $request)
    {

        //Obteniendo los parámetros opcionales de limit y offset
        $limit = $request->limit;
        $offset = $request->offset;

        //Obteniendo header para identificar el usuario solicitante
        $token = $request->header('Authorization');

        $i = 0;
        if ($token != null) {
            //Consultamos el usuario que solicita la información mediante el api_token
            $user = User::where('api_token', '=', $token)->get();

            //Obtenemos los registros de todos los usuarios

            //$leaders = User::orderBy('level', 'desc')->get();
            $leaders = DB::table('users')
                ->join('games', 'users.id', '=', 'games.user_id')
                ->select('users.id','users.level', DB::raw("count(games.result_type) as victories_count"))
                ->where('games.result_type','=','2')
                ->groupBy('users.id','users.level')
                ->orderBy('victories_count','desc')
                ->get();


            //Creando array con los datos recibidos desde base de datos
            foreach ($leaders as $leader) {
                $i++;
                $array[] = array("userid" => $leader->id, "level" => $leader->level, "rank" => $i);
            }

            //Agregando el rank en el array del usuario que solicita la información
            foreach ($user as $v) {
                $arrayUser[] = array("userid" => $v->id, "level" => $v->level);
            }

            return response()->json(["Request User" => $arrayUser, 'entries' => $array]);
        }else{
            return response()->json(["Error"=>'Debe indicar el header authorization']);
        }
    }
}
