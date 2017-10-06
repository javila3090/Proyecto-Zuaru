<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Post;
use App\User;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Post::all();
    }

    public function show(Request $request, $user_id)
    {
        $limit=$request->limit;
        $offset=$request->offset;
        if($limit!=null){
            $post = DB::table('posts')->where('user_id', '=', $user_id)->offset($offset)->limit($limit)->get();
        }else{
            $post = DB::table('posts')->where('user_id', '=', $user_id)->get();
        }
        return response()->json(['posts' => $post]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{
            Post::create($request->json()->all());
            return response()->json(['success' => true]);
        }catch(Exception $e){
            return response()->json(['Error' => true, 'ErrorMessage' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        return response()->json(['success' => true], 200);
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
