<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perrito;
use file;
use Illuminate\Support\Facades\Storage;

class PerritosController extends Controller
{
      public function obtenerPerritos(){
        $objeto = Perrito::all();

        return response()->json([$objeto],200);
    }

    public function ingresarPerrito(Request $request){

        if($request->isJson()){




            $perrito = Perrito::where('nombre','=',$request->nombre)->first();

            $base64_image = $request->input('foto'); // your base64 encoded
            @list($type, $file_data) = explode(';', $base64_image);
            @list(, $file_data) = explode(',', $file_data);
            $imageName = $request->nombre.'.jpg';
            $path = Storage::disk('public')->put($imageName, base64_decode($file_data));

            if($perrito == null){

                $objeto = Perrito::create([
                    'nombre'=>$request->nombre,
                    'color'=>$request->nombre,
                    'raza'=>$request->nombre,
                    'foto'=> 'http://test-main.test/storage/'.$imageName,
                ]);

                return response()->json([$objeto],200);
            }
            return response()->json(['error' => "el nombre  de perrito ya existe porfavor ingrese otro"],201);


        }
        return response()->json(['error' => "no se pudo ingresar perrito"],401);
    }


    public function obtenerPerrito($id){
        $objeto = Perrito::where('id','=',$id)->first();

        return response()->json([$objeto],200);
    }


    public function actualizarPerrito(Request $request,$id){

        if($request->isJson()){
            $data = $request->json()->all();

            $objeto = Perrito::where('id','=',$id)->first();

            $objeto->update([
                'nombre'=> $data['nombre'],
                'color'=> $data['color'],
                'raza'=> $data['raza']
            ]);

            return response()->json([$objeto],201);
        }
        return response()->json(['error' => "no se pudo actualizar perrito"],401);

    }

    public function eliminarPerrito($id){

        if($id){
            $objeto = Perrito::where('id','=',$id)->delete();

            return response()->json(['ok' => "El perrito ha sido eliminado exisotamente"],200);
        }
        return response()->json(['error' => "el perrito no pudo ser eliminado"],401);
    }
}
