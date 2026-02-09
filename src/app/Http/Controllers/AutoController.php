<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutoController extends Controller
{
    /**
     * Mostrar una lista del recurso.
     */
    public function index()
    {
        // Recuperar todos los recursos
        $Autos = Auto::all();
        // Es analogo a: select * from Autos;
        // Retornar los recursos recuperados
        $respuesta = [
            'Autos' => $Autos,
            'status' => 200,
        ];
        return response()->json($respuesta);
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
        {
            $data = $request->json()->all();

            $validator = Validator::make($data, [
                'modelo' => 'required',
                'marca' => 'required',
                'anio' => 'required|integer|digits:4',
                'color' => 'required',
                'cilindrada' => 'required',
                'precio' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Datos faltantes',
                    'errors' => $validator->errors(),
                ], 400);
            }

            $auto = Auto::create($data);

            return response()->json([
                'message' => 'Auto registrado correctamente',
                'data' => $auto,
            ], 201);
        }
    /**
     * Mostrar el recurso especificado.
     */
    public function show($id)
    {
        // Recuperar el recurso especificado
        // esto seria el equivalente a: select * from Autos where id = $id;
        $Auto = Auto::find($id);
    
        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$Auto) {
            $respuesta = [
            'message' => 'Auto no encontrado',
            'status' => 404, // No encontrado
            ];
            return response()->json($respuesta, 404);
        }

        // Retornar el recurso recuperado
        $respuesta = [
            'Auto' => $Auto,
            'status' => 200, // OK
        ];
        return response()->json($respuesta);
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, $id)
    {
        // Recuperar el recurso especificado
        $Auto = Auto::find($id);

        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$Auto) {
        $respuesta = [
        'message' => 'Auto no encontrado',
        'status' => 404, // No encontrado
        ];
        return response()->json($respuesta, 404);
        }

        // Validar que la petición contenga todos los datos necesarios
        $validator = Validator::make($request->all(), [
            'modelo' => 'required',
            'marca' => 'required',
            'anio' => 'required|integer|digits:4',
            'color' => 'required',
            'cilindrada' => 'required',
            'precio' => 'nullable|numeric',
        ]);

        // Si la petición no contiene todos los datos necesarios, retornar un mensaje de error
        if ($validator->fails()) {
            $respuesta = [
            'message' => 'Datos faltantes',
            'status' => 400, // Petición inválida
            ];
            return response()->json($respuesta, 400);
        }

        // Actualizar el recurso especificado con los datos de la petición
        // este es el equivalente a un: UPDATE Autos SET ... WHERE id = $id;
        $Auto->modelo = $request->modelo;
        $Auto->marca = $request->marca;
        $Auto->anio = $request->anio;
        $Auto->color = $request->color;
        $Auto->cilindrada = $request->cilindrada;
        $Auto->precio = $request->precio;

        $Auto->save();
        // Retornar el recurso actualizado
        $respuesta = [
            'Auto' => $Auto,
            'status' => 200, // OK
        ];
        return response()->json($respuesta);
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
        // Recuperar el recurso especificado
        $Auto = Auto::find($id);

        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$Auto) {
            $respuesta = [
            'message' => 'Auto no encontrado',
            'status' => 404, // No encontrado
        ];
        return response()->json($respuesta, 404);
        }

        // Eliminar el recurso especificado
        // esto es el equivalente a un: DELETE FROM Autos WHERE id = $id;
        $Auto->delete();

        // Retornar un mensaje de éxito
        $respuesta = [
        'message' => 'Auto eliminado',
        'status' => 200, // OK
        ];
        return response()->json($respuesta);
    }
}
