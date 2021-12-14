<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        //Listamos todos los Useros
        return User::get();
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
            'name',
            'surname',
            'email',
            'password',
        );
        $validator = Validator::make($data, [
            'name' =>'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password'=> 'required|string|min:1|max:24',
            
        ]);
        //Si falla la validación
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Creamos el Usero en la BD
        $user = User::create([
            'name' => $request->name,
            'surname'=>$request->surname,
            'email' => $request->email,
            'password' => $request->bcrypt($request->password)     
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'User created',
            'data' => $user
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el Usero
        $user = User::find($id);
        //Si el Usero no existe devolvemos error no encontrado
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }
        //Si hay Usero lo devolvemos
        return $user;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación de datos
        $data = $request->only(
            'name',
            'surname',
            
        );
        $validator = Validator::make($data, [
            'name' =>'required|string',
            'surname' => 'required|string',
            'email' => 'email|unique:users',
            'password'=> 'string|min:1|max:24',
            
        ]);
        //Si falla la validación error.
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Buscamos el User
        $user = User::findOrfail($id);
        //Actualizamos el User.
        $user->update([
            'name' => $request->name,
            'surname'=>$request->surname,
            'email' => $request->email,
           /*  'password' => $request->bcrypt($request->password) */  
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el Usero
        $user = User::findOrfail($id);
        //Eliminamos el Usero
        $user->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'User deleted successfully'
        ], Response::HTTP_OK);
    }
}
