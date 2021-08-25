<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Post;

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
            $post->title = $request->title;
            $post->brief = $request->brief;
            $post->context = $request->context;
            $post->image = $request->image;
            $post->status = $request->status;
            $post->user_id = $request->user_id;

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
        $exito = false;
        DB::beginTransaction();

        try {
            $post = Post::find($request->id_question);
            $post->context = $request->response_ques;
            $post->status = 0; //ESTADO CONTESTADA LA RESPUESTA
            $post->save();
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollBack();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al actulizar la respuesta los datos",
                "error" => $th
            ], 500);
        }
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
}
