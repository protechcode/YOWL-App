<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
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
        //Listamos todos los Reviewos
       $review = Review::get();
       return response()->json(['review' => $review[0]]);
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
            'user_id',
            'provider_id'
        );
        $validator = Validator::make($data, [
            'title' => 'required|max:240|string',
            'content' => 'required|max:250|string',
            
        ]);
        //Si falla la validación
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Creamos el Reviewo en la BD
        $review = Review::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
            'provider_id' => $request->provider_id,            
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Review created',
            'data' => $review
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el Reviewo
        $review = Review::find($id);
        //Si el Reviewo no existe devolvemos error no encontrado
        if (!$review) {
            return response()->json([
                'message' => 'Review not found.'
            ], 404);
        }
        //Si hay Reviewo lo devolvemos
        return $review;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación de datos
        $data = $request->only('name', 'content');
        $validator = Validator::make($data, [
            'name' => 'required|max:50|string',
            'content' => 'required|max:50|string',
            
        ]);
        //Si falla la validación error.
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Buscamos el Reviewo
        $review = Review::findOrfail($id);
        //Actualizamos el Reviewo.
        $review->update([
            'name' => $request->name,
            'content' => $request->content,
         
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Review updated successfully',
            'data' => $review
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el Reviewo
        $review = Review::findOrfail($id);
        //Eliminamos el Reviewo
        $review->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Review deleted successfully'
        ], Response::HTTP_OK);
    }
}
