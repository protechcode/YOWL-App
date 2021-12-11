<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
{
    protected $provider;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo almacenamos en una variable, nosotros no lo utilizaremos.
            $this->Provider = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Listamos todos los Provideros
        return Provider::get();
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
        $data = $request->only('name', 'email', 'password',);
        ///se valida la $data
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:1|max:24',
        ]);
        //Si falla la validación
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Creamos el Providero en la BD
        $provider = Provider::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_id' =>$request->user_id,
            'phone' => $request->phone,
            'location_1' => $request->location_1,
            'location_2' => $request->location_2,
            'password' =>  $request->bcrypt($request->password),
            
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Provider created',
            'data' => $provider
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el Providero
        $provider = Provider::find($id);
        //Si el Providero no existe devolvemos error no encontrado
        if (!$provider) {
            return response()->json([
                'message' => 'Provider not found.'
            ], 404);
        }
        //Si hay Providero lo devolvemos
        return $provider;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación de datos
        $data = $request->only('name', 'email', 'password',);
        ///se valida la $data
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:1|max:24',
        ]);
        //Si falla la validación error.
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Buscamos el Provider
        $provider = Provider::findOrfail($id);
        //Actualizamos el Provider.
        $provider->update([
            'name' => $request->name,
            'email' => $request->email,
            'user_id' =>$request->user_id,
            'phone' => $request->phone,
            'location_1' => $request->location_1,
            'location_2' => $request->location_2,
            /* 'password' =>  $request->bcrypt($request->password), */
           /*  'password' => $request->bcrypt($request->password) */  
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Provider updated successfully',
            'data' => $provider
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el Providero
        $provider = Provider::findOrfail($id);
        //Eliminamos el Providero
        $provider->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Provider deleted successfully'
        ], Response::HTTP_OK);
    }
}
