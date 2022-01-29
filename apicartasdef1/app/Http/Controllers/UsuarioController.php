<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function registrar(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
        $clave = $data->contraseña;
            if(!preg_match('`[0-9]`', $clave) || !preg_match('`[a-z]`', $clave) || strlen($clave) < 6){
                $response = "La clave debe tener al menos una letra minúscula, un numero y tener mas de 6 caracteres";
            }else{
                $usuario = new Usuario;
                $usuario->nombre = $data->nombre;
                $usuario->email = $data->email;
                $usuario->contraseña = Hash::make($data->contraseña);
                $usuario->clase = $data->clase;
                $usuario->save();
                $response["msg"] = $usuario;
                }
            return response()->json($response);
    }
    
    public function login(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
        $user = Usuario::where('nombre',$data->nombre)->first();
        if($user){
            $response['msg1']="nombre coincide";
            
            if (Hash::check($data->contraseña, $user->contraseña)) {
                $response['msg2']="contraseña coincide";
                $user->token = Hash::make($data->nombre);
                $user->save();
                $response['msg5']=$user->token;
                //crear y asignar token
            }else{
                $response['msg3']="contraseña no coincide";
            }
        }else{
        
            $response['msg4']="no coincide nombre";
        }
        return response()->json($response);
    }
}
