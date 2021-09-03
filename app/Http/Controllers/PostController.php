<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $questions = Post::where('status', 1)->get(); //ESTADO SIN RESPONDER Y NO ESTA ALIMINADA

        $array = array();
        foreach($questions as $question) {
            $user = User::whereId($question->user_id)->first();
            $objectQuestion = new \stdClass();
            $objectQuestion->id_question = $question->id;
            $objectQuestion->title = $question->title;
            $objectQuestion->brief = $question->brief;
            $objectQuestion->context = $question->context;
            $objectQuestion->user_name = $user->name;
            array_push($array, $objectQuestion);
        }
        if ($array) {
            return response()->json([
                "questions" => $array
            ], 200);
        } else {
            return response()->json([
                "error" => "No hay nada en la BD"
            ], 250);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $exito = false;
        DB::beginTransaction();

        try {

            $post = new Post;
            $post->title = $request->pregunta;
            $post->user_id = $request->id_user;
            $post->save();
            DB::commit();
            $exito = true;

        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
        }

        if($exito){
            return response()->json([
                "status" => "ok",
                "message" => "Post guardado con exito",
                "post" => $post
            ], 200);
        }else{
            return response()->json([
                "status" => "error",
                "message" => "Error al intentar guardar registros"
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Se agrega la respuesta a la pregunta, actulizando el atributo context
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Cambiamos el estado para que asi no pueda ser vista
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyStatus(Request  $request)
    {
        $exito = false;
        DB::beginTransaction();
        // return response()->json([
        //     "request" => $request->id_question
        // ]);
        try {
            $post = Post::find($request->id_question);
            $post->status = 2; //ESTADO ALIMINADA LA RESPUESTA
            $post->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollBack();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al eliminar los datos",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Pregunta eliminada correctamente",
                "question" => $post
            ], 200);
        }
    }

    public function indexHome(){ 
        $comments = Comment::all();
        $array = array();
        foreach($comments as $comment) {
            $post = $comment->post;
            $likes = Like::where("post_id",$post->id)->count();
            $user = User::whereId($post->user_id)->first();
            $objectQuestion = new \stdClass();
            $objectQuestion->id_question = $comment->id;
            $objectQuestion->title = $post->title;
            $objectQuestion->context = $comment->comment;
            $objectQuestion->user_name = $user->name;
            $objectQuestion->user_id = $user->id;
            $objectQuestion->post_id = $post->id;
            $objectQuestion->likes = $likes;
            array_push($array, $objectQuestion);
        }
        if ($array) {
            return response()->json([
                "questionsRes" => $array
            ], 200);
        } else {
            return response()->json([
                "error" => "No hay nada en la BD"
            ], 250);
        }
    }

    public function likes(Request $request) {
        $exito = false;
        DB::beginTransaction();
        try {
            $like = new Like;
            $like->user_id = $request->user_log_id;
            $like->post_id = $request->post_id;
            $like->like = 1;
            $like->save();
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollBack();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al dar like",
                "error" => $th
            ], 500);
        }
        if ($exito) {
            return response()->json([
                "message" => "Like con exito",
                "question" => $like
            ], 200);
        }
    }
    public function dislikes(Request $request) {
        $exito = false;

        DB::beginTransaction();

        try {
            $user = User::find($request->user_log_id);

            $user->likes()->detach($request->id_post);

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "exito" => "dislike"
            ], 200);
        }

    }
}
