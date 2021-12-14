<?php

namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //Funcion register (new user)
    public function register(Request $request)
    {
        //definimos $data
        $data = $request->only('name', /* 'surname', */ 'email', 'password',);
        ///se valida la $data
        $validator = Validator::make($data, [
            'name' =>'required|string',
            /* 'surname' => 'required|string', */
            'email' => 'required|email|unique:users',
            'password'=> 'required|string|min:1|max:24',
        ]);
        //catch errors
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        //Se crea el usuario
        $user = User::create([
            'name' => $request->name,
            'surname'=>$request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    
        //guardamos el usuario y la contraseña para pedir el token a JWTAUTH
        $credentials = $request->only('email', 'password');
        //devolvemos la respuesta y el token
        return response()->json([
            'message' => 'user created !!!',
            'token' => JWTAuth::attempt($credentials),
            'user' => $user
        ], Response::HTTP_OK);


    }
    //login
    public function authenticate(Request $request)
    {
  
        //Requerimos solo email y password
        $credentials = $request->only('email', 'password');
        //se valida la data
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:1|max:12'
        ]);
       
        // 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        try{
            if (!$token = JWTAuth::attempt($credentials)) {
                //Error en credenciales
                return response()->json([
                    'message ' => 'Login failed',
                ], 401);
            }
        }catch( JWTException $error){
            //error interno en el servidor
            return response()->json([
                'message' => 'ERROR'
            ], 500);
        }
        //Token
        return response()->json([
            'token' => $token,
            'user' => Auth::user()
        ]);
    }
    ///Delete token and prepare for new user
    public function logout(Request $request)
    {
        //Validamos que se nos envie el token
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);
        //Si falla la validación
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        try {
            //Si el token es valido eliminamos el token desconectando al usuario.
            JWTAuth::logout($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User disconnected'
            ]);
        } catch (JWTException $exception) {
            //Error chungo
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getUser(Request $request)
    {
        //Validamos que la request tenga el token
        $validator= Validator::make($request->only('token'), [
            'token' => 'required'
        ]);
           //Si falla la validación
           if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        //Realizamos la autentificación
        $user = JWTAuth::authenticate($request->token);
        //Si no hay usuario es que el token no es valido o que ha expirado
        if(!$user)
            return response()->json([
                'message' => 'Invalid token / token expired',
            ], 401);
        //Devolvemos los datos del usuario si todo va bien. 
        return response()->json(['user' => $user]);
    }

}
/*  */
