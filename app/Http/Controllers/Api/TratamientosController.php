<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratamientosController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::with(['diagnostico', 'medico'])->get();
        return response()->json($tratamientos, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'                    => 'required|string|max:255',
            'descripcion'               => 'required|string',
            'duracion'                  => 'required|string|max:255',
            'diagnostico_id'            => 'required|exists:diagnosticos,id',
            'medico_id'                 => 'required|exists:medicos,id',
            'estado'                    => 'required|string|max:255',
            'frecuencia_administracion' => 'required|string|max:255',
        ]);

        $tratamiento = Tratamiento::create($request->all());
        return response()->json([
            'message' => 'Tratamiento registrado con éxito vía API.',
            'data' => $tratamiento
        ], 201);
    }

    public function show(string $id)
    {
        return response()->json(Tratamiento::with(['diagnostico', 'medico'])->findOrFail($id), 200);
    }

    public function update(Request $request, string $id)
    {
        $tratamiento = Tratamiento::findOrFail($id);
        $tratamiento->update($request->all());

        return response()->json([
            'message' => 'Tratamiento actualizado correctamente vía API.',
            'data' => $tratamiento
        ], 200);
    }

    public function destroy(string $id)
    {
        Tratamiento::findOrFail($id)->delete();
        return response()->json(['message' => 'Tratamiento eliminado de la API.'], 200);
    }
}