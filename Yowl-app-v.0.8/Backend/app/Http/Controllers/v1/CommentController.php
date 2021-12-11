<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo almacenamos en una variable, nosotros no lo utilizaremos.
            $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Listamos todos los Commentos
        return Comment::get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validamos los datos
        $data = $request->only(
            'title',
            'content',
            'review_id',
            'user_id'
        );
        $validator = Validator::make($data, [
            'title' => 'required|max:240|string',
            'content' => 'required|max:250|string',
            
        ]);
        //Si falla la validación
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Creamos el Commento en la BD
        $comment = Comment::create([
            'title' => $request->title,
            'content' => $request->content,
            'review_id' => $request->review_id,            
            'user_id' => $request->user_id,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Comment created',
            'data' => $comment
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el Commento
        $comment = Comment::find($id);
        //Si el Commento no existe devolvemos error no encontrado
        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found.'
            ], 404);
        }
        //Si hay Commento lo devolvemos
        return $comment;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación de datos
        $data = $request->only(
            'title',
            'content',
            'review_id',
            'user_id'
        );
        $validator = Validator::make($data, [
            'title' => 'required|max:240|string',
            'content' => 'required|max:250|string',
            
        ]);
       
        //Si falla la validación error.
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Buscamos el Commento
        $comment = Comment::findOrfail($id);
        //Actualizamos el Commento.
        $comment->update([
            'title' => $request->title,
            'content' => $request->content,
            'review_id' => $request->provider_id,  
            'user_id' => $request->user_id,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Comment updated successfully',
            'data' => $comment
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el Commento
        $comment = Comment::findOrfail($id);
        //Eliminamos el Commento
        $comment->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Comment deleted successfully'
        ], Response::HTTP_OK);
    }
}
