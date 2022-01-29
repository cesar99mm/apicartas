<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carta;
use App\Models\Coleccion;
use App\Models\Cartascole;
use App\Models\Usuario;
use App\Models\CartasUsuario;

class CartasController extends Controller
{
    public function subirCarta(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
                $carta = new Carta;
                $carta->nombre = $data->nombre;
                $carta->descripcion = $data->descripcion;
                //$carta->alta = $data->alta;//mal
                //haceer que cree lineas en la tabla de  coleccionesxcarta
                $carta->save();
                $response["msg"] = $carta;
                
            return response()->json($response); 
    }



    public function subirColeccion(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
                $coleccion = new Coleccion;
                $coleccion->nombre = $data->nombre;
                $coleccion->simbolo = $data->simbolo;
                //$carta->alta = $data->alta;//mal
                //haceer que cree lineas en la tabla de  coleccionesxcarta
                $coleccion->save();
                $response["msg"] = $coleccion;
                
            return response()->json($response); 

    }

    public function altaCarta(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
        $cartaid = Cartascole::where('id_carta',$data->id_carta)->first();
        if($cartaid){
            $carta = Carta::find($data->id_carta);
            $carta->alta = 1;
            $carta->save();
            $response["msg1"] = $carta;
            //cambiar boolean
        }
        else{
            $response["msg"] = "no existe carta ligada a una coleccion con esa id";
        }
    }
    public function altaColeccion(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
        $coleid = Cartascole::where('id_coleccion',$data->id_coleccion)->first();
        if($coleid){
            $coleccion = Coleccion::find($data->id_coleccion);
            $coleccion->alta = 1;
            $coleccion->save();
            $response["msg1"] = $coleccion;
            //cambiar boolean
        }
        else{
            $response["msg"] = "no existe carta ligada a una coleccion con esa id";
        }
    }
    public function cartaAColeccion(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
        $carta = Carta::where('id',$data->id_carta)->first();
        if($carta){
            $coleccion = Coleccion::where('id',$data->id_coleccion)->first();
                if($coleccion){
                    $cartascole = new Cartascole;
                    $cartascole->id_carta = $data->id_carta;
                    $cartascole->id_coleccion = $data->id_coleccion;
                    $cartascole->save();
                    $response["msg"] = $cartascole;
                }else{ 
                    $response["msg"] = "no existe la coleccion";
                }
            }else{
                $response["msg"] = "no existe la carta";
            }
        return response()->json($response); 
    }
    public function busquedaNombre(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
        $carta = Carta::where('nombre', 'LIKE', '%'.$data->nombre.'%')->get();
        $response["msg"] = $carta;
    }
    public function subirOferta(Request $request){
        $jdata = $request->getContent();
        $data = json_decode($jdata);
    }
    
}
