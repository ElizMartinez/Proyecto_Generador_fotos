<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\proyectos;
use App\Models\coleccion;
use Exception;

class ProyectosController extends Controller
{
    public function agregarProyecto(Request $request)
    {
        try {
            $request->validate([
                'nombre_proyecto' => 'required|unique:proyectos,nombre_proyecto',
                'expediente' => 'required',
                'descripcion' => 'string',
            ]);

            $proyecto = proyectos::create($request->all());

            return response()->json(['message' => 'Proyecto agregado con éxito', 'data' => $proyecto], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al agregar el proyecto', 'error' => $e->getMessage()], 500);
        }
    }

    public function editarProyecto(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre_proyecto' => 'nullable',
                'expediente' => 'nullable',
                'descripcion' => 'nullable',
            ]);

            $proyecto = proyectos::find($id);
            if ($proyecto) {
                $datos = $request->all();

                $datos = array_filter($datos, function ($valor) {
                    return $valor !== null;
                });
                $proyecto->update($datos);
                return response()->json(['message' => 'Proyecto actualizado con éxito', 'data' => $proyecto], 200);
            }

            return response()->json(['error' => 'El proyecto no existe']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al actualizar el proyecto', 'error' => $e->getMessage()], 500);
        }
    }

    public function eliminarProyecto($id)
    {
        try {
            $proyecto = proyectos::find($id);
            if ($proyecto) {
                $proyecto->forceDelete();
                return response()->json(['message' => 'Proyecto eliminado con éxito'], 200);
            }

            return response()->json(['message' => 'No se encontró el proyecto'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al eliminar el proyecto', 'error' => $e->getMessage()], 500);
        }
    }


    public function listarProyectos()
    {
        try {
            $proyectos = proyectos::all();
            $proyectosFormatted = [];

            foreach ($proyectos as $proyecto) {
                $proyectosFormatted[] = [
                    "id" => $proyecto->id_proyecto,
                    "nombre_proyecto" => $proyecto->nombre_proyecto,
                    "expediente" => $proyecto->expediente,
                    "descripcion" => $proyecto->descripcion,
                    "fecha_creacion" => $proyecto->created_at,
                ];
            }

            return response()->json($proyectosFormatted, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al listar los proyectos', 'error' => $e->getMessage()], 500);
        }
    }

    public function verProyecto($id)
    {
        try {
            $proyecto = proyectos::find($id);
            $coleccion = $proyecto ->coleccion;
            $proyectosFormatted = [
                "id" => $proyecto->id_proyecto,
                "nombre_proyecto" => $proyecto->nombre_proyecto,
                "expediente" => $proyecto->expediente,
                "descripcion" => $proyecto->descripcion,
                "fecha_creacion" => $proyecto->created_at,
            ];
            
            if ($proyecto) {
                return response()->json(['code'=> "200"
                ,'message' => 'Proyecto encontrado', 'data' => $proyectosFormatted, 'coleccion' => $coleccion], 200);
            }
            return response()->json(['error' => 'proyecto no encontrado']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al ver el proyecto', 'error' => $e->getMessage()], 500);
        }
    }
}