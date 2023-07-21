<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\coleccion;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

use Exception;

class ColeccionController extends Controller
{
    public function agregarColeccion(Request $request, $id)
    {
        try {
            $request->validate(['nombre' => 'required|unique:coleccion,nombre_coleccion']);
            $coleccion = coleccion::create([
                'nombre_coleccion' => $request->nombre,
                'proyecto_id' => $id
            ]);
            return response()->json(['code' => 201, 'message' => 'created succesfully']);
        } catch (Exception $e) {
            return response()->json(['code' => 404, 'message' => 'not found', 'errors' => $e]);
        }
    }
    public function editarColeccion(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'unique:coleccion,nombre_coleccion',
            ]);

            $coleccion = coleccion::find($id);

            if ($coleccion) {
                $coleccion->nombre_coleccion = $request->input('nombre');
                $coleccion->save();

                return response()->json(['code' => 200, 'message' => 'updated successfully']);
            }

            return response()->json(['code' => 404, 'message' => 'collection does not exist']);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => 'error', 'error' => $e->getMessage()]);
        }
    }

    public function deleteColeccion(Request $request, $id)
    {
        try {
            $coleccion = coleccion::find($id);
            if ($coleccion) {
                $coleccion->delete();
                return response()->json(['code' => 200, 'message' => 'deleted succesfully']);
            }
            return response()->json(['code' => 404, 'message' => 'collection does not exist']);
        } catch (Exception $e) {
            return response()->json(['code' => 404, 'message' => 'not found', 'errors' => $e]);
        }
    }
    public function colecciones($id)
    {
        try {
            $coleccion = coleccion::where('proyecto_id', $id)->get();
            if ($coleccion) {
                return response()->json(['code' => 200, 'message' => 'success', 'data' => $coleccion]);
            }
            return response()->json(['code' => 404, 'message' => 'collection does not exist']);
        } catch (Exception $e) {
            return response()->json(['code' => 404, 'message' => 'not found', 'errors' => $e]);
        }
    }
    public function coleccion($id)
    {
        try {
            $coleccion = coleccion::find($id);
            $fotos = $coleccion->fotos;
            if ($coleccion) {
                return response()->json(['code' => 200, 'message' => 'success', 'data' => $coleccion]);
            }
            return response()->json(['code' => 404, 'message' => 'collection does not exist']);
        } catch (Exception $e) {
            return response()->json(['code' => 404, 'message' => 'not found', 'errors' => $e]);
        }
    }

    public function coleccionWord($id)
    {
        try {
            $coleccion = Coleccion::find($id);
            $fotos = $coleccion->fotos;
    
            if (!$coleccion) {
                return response()->json(['message' => 'Coleccion no encontrada'], 404);
            }
    
            $proyecto = $coleccion->proyecto;
            $nombreProyecto = $proyecto ? $proyecto->nombre_proyecto : '';
            $expediente = $proyecto ? $proyecto->expediente : '';
            $descripcion = $proyecto ? $proyecto->descripcion : '';
    
            $outputPath = storage_path('app/public/word/' . $coleccion->nombre_coleccion . '.docx');
    
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();
    
            $collectionTitleStyle = [
                'bold' => true,
                'size' => 16,
                'color' => '000000',
                'underline' => 'single',
                'align' => 'center',
            ];
            $phpWord->addTitleStyle(1, $collectionTitleStyle);

            $photoTitleStyle = [
                'bold' => true,
                'size' => 14,
                'color' => '000000',
                'align' => 'center',
            ];
  
            $section->addTitle('Proyecto: ' . $nombreProyecto, 1);
            $section->addText('Expediente: ' . $expediente);
            $section->addText('Descripción: ' . $descripcion);
            $section->addTextBreak();
            $section->addTitle('Nombre Anejo: ' . $coleccion->nombre_coleccion, 1);
    
            $photoIndex = 1;
    
            $photoTitles = [];
    
            foreach ($fotos as $foto) {
                $section->addText('Titulo: ' . $foto->titulo_foto, $photoTitleStyle);
                $section->addText('Descripcion: ' . $foto->descripcion_foto);
                $section->addText('Pie de foto: ' . $foto->pie_foto);
    
                $imagePath = storage_path('app/' . $foto->path);
                $section->addImage($imagePath, [
                    'width' => 200,
                    'height' => 200,
                    'align' => 'center',
                ]);
    
                $section->addTextBreak();
                $photoTitles[] = $foto->titulo_foto;
    
                $photoIndex++;
            }
            $section->addText('Índice', $collectionTitleStyle);
            $section->addTextBreak();
    
            foreach ($photoTitles as $index => $title) {
                $section->addText('Foto ' . ($index + 1) . ' - ' . $title, ['bold' => true]);
            }
    
            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($outputPath);
    
            return response()->json(['message' => 'Documento Word generado con éxito', 'file_path' => $outputPath], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al generar el documento Word', 'error' => $e->getMessage()], 500);
        }
    }
    
}