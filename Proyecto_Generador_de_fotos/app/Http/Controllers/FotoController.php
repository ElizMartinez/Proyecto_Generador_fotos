<?php

namespace App\Http\Controllers;

use App\Models\coleccion;
use Illuminate\Http\Request;
use App\Models\fotos;
use Exception;

class FotoController extends Controller
{
    public function agregarImagen(Request $request, $id)
    {
        try {
            $request->validate([
                'titulo_foto' => 'string',
                'descripcion_foto' => 'string',
                'pie_foto' => 'string',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if (coleccion::find($id)){
                $imagen = $request->file('imagen');
                $nombreImagen = uniqid() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = $imagen->storeAs('public/fotos', $nombreImagen);
        
                $foto = fotos::create([
                    'titulo_foto' => $request->input('titulo_foto'),
                    'descripcion_foto' => $request->input('descripcion_foto'),
                    'pie_foto' => $request->input('pie_foto'),
                    'coleccion_id' => $id,
                    'path' => $rutaImagen,
                ]);
        
                return response()->json(['message' => 'Foto agregada con éxito', 'data' => $foto], 201);
            }

            return response()->json (['message'=> 'Coleccion no existente'], 500);
    
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al agregar la foto', 'error' => $e->getMessage()], 500);
        }
    }
    public function editarImagen(Request $request, $id)
{
    try {
        $request->validate([
            'titulo_foto' => 'nullable|string',
            'descripcion_foto' => 'nullable|string',
            'pie_foto' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $foto = fotos::find($id);

        if (!$foto) {
            return response()->json(['message' => 'Foto no encontrada'], 404);
        }

        $campos = $request->only(['titulo_foto', 'descripcion_foto', 'pie_foto']);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = $imagen->storeAs('public/fotos', $nombreImagen);
            $campos['path'] = $rutaImagen;
        }

        $foto->update($campos);

        return response()->json(['message' => 'Foto actualizada con éxito', 'data' => $foto], 200);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error al editar la foto', 'error' => $e->getMessage()], 500);
    }
}
public function eliminarImagen($id){
    try {
        $foto = fotos::find($id);

        if (!$foto) {
            return response()->json(['message' => 'Foto no encontrada'], 404);
        }

        $foto->delete();

        return response()->json(['message' => 'Foto eliminada con éxito'], 200);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error al eliminar la foto', 'error' => $e->getMessage()], 500);
    }
}

public function verImagen($id){
    try {
        $foto = fotos::find($id);

        if (!$foto) {
            return response()->json(['message' => 'Foto no encontrada'], 404);
        }

        return response()->json(['message' => 'Foto obtenida con éxito', 'data' => $foto], 200);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error al obtener la foto', 'error' => $e->getMessage()], 500);
    }
}
    
   public function verImagenesColeccion($id){
    try {
        $fotos = fotos::where('coleccion_id', $id)->get();

        if (!$fotos) {
            return response()->json(['message' => 'Fotos no encontradas'], 404);
        }

        return response()->json(['message' => 'Fotos obtenidas con éxito', 'data' => $fotos], 200);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error al obtener las fotos', 'error' => $e->getMessage()], 500);
    }
   }
}