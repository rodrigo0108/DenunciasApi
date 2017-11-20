<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Usuario;

class ApiController extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        if (Auth::once($credentials)) 
        {
         $user = Auth::user();
         
         return $user;
        }
        return response()->json(['error' => 'Usuario y/o clave inválido'], 401); 
    }
    public function register_user(Request $request){
        try
        {
            if(!$request->has('username') || !$request->has('password')|| !$request->has('email'))
            {
                throw new \Exception('Se esperaba campos mandatorios');
            }
            
            $user = new Usuario();
            $user->username = $request->get('username');
    		$user->password = bcrypt($request->get('password'));
    		$user->email = $request->get('email');
    		$user->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function show_user($id){
        try
        {
            $user = Usuario::find($id);
            
            if($user == null)
                throw new \Exception('Registro no encontrado');
    		
            return $user;
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    
}
