<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProviderAuthController extends Controller
{
    //Funcion register (new user)
    public function register(Request $request)
    {
        //definimos $data
        $data = $request->only('name', 'email', 'password',);
        ///se valida la $data
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:providers',
            'password' => 'required|string|min:1|max:24',
        ]);
        //catch errors
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        //Se crea el usuario
        $provider = Provider::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_id' =>$request->user_id,
            'phone' => $request->phone,
            'location_1' => $request->location_1,
            'location_2' => $request->location_2,
            'password' =>  Hash::make($request->password)
            
        ]);
        $token = JWTAuth::fromUser($provider);
        $user = User::create([
            'name' => $request->name,
            'surname'=> $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password)
            
        ]);
        $token = JWTAuth::fromUser($user);
       

        return response()->json(compact('user','token'),201);
    
    }
    //login
    public function authenticate(Request $request)
    {
        //Requerimos solo email y password $request->only('email', 'password');
        $credentials = $request->only('email', 'password');
        //se valida la data
        $validator = Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string|min:1'
        ]);
       
        // 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }

        try{
           /*  $token = JWTAuth::attempt($credentials);
            return response()->json($credentials); */
            if (!$token = auth()->attempt($credentials)) {
                
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
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }
        try {
            $user= JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User disconnected, ready for new login'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'ERROR'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        $provider = JWTAuth::authenticate($request->token);
        if (!$provider) {
            return response()->json([
                'message' => 'Invalid/Token/Token/Expired'
            ], 401);
            return response()->json(['provider' => $provider]);
        }
    }
}
