<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Usuario;
class administrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       
        $jdata = $request->getContent();
        $data = json_decode($jdata);
        $userVal = Usuario::where('token',$data->token)->first();
        if ($userVal->clase = "administrador"){
            return $next($request);
        }else{
            $response['msg1']="no tienes permisos";
            return($response);
        }
    }
}
