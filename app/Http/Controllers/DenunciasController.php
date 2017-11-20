<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Denuncia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class DenunciasController extends Controller
{
       public function index()
    {
        $denuncias = Denuncia::all();
	    
	    return $denuncias;
    }
    
    public function store(Request $request)
    {
        try
        {
            if(!$request->has('titulo') || !$request->has('comentario')|| !$request->has('latitud')|| !$request->has('longitud') || !$request->has('usuarios_id'))
            {
                throw new \Exception('Se esperaba campos mandatorios');
            }
            
            $denuncia = new Denuncia();
            $denuncia->titulo = $request->get('titulo');
    		$denuncia->comentario = $request->get('comentario');
    		$denuncia->latitud = $request->get('latitud');
    		$denuncia->longitud = $request->get('longitud');
    		$denuncia->usuarios_id = $request->get('usuarios_id');
    		
    		if($request->hasFile('imagen') && $request->file('imagen')->isValid())
    		{
        		$imagen = $request->file('imagen');
        		$filename = $request->file('imagen')->getClientOriginalName();
        		
        		Storage::disk('images')->put($filename,  File::get($imagen));
        		
        		$denuncia->imagen = $filename;
    		}
    		
    		$denuncia->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function destroy($id){
        try
        {
            $denuncia = Denuncia::find($id);
            
            if($denuncia == null)
                throw new \Exception('Registro no encontrado');
    		
    		if(Storage::disk('images')->exists($denuncia->imagen))
    		    Storage::disk('images')->delete($denuncia->imagen);
    		
    		$denuncia->delete();
    		
            return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function show($id){
        try
        {
            $denuncia = Denuncia::find($id);
            
            if($denuncia == null)
                throw new \Exception('Registro no encontrado');
    		
            return $denuncia;
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

        
}
