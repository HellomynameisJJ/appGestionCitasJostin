<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diagnostico;
use Illuminate\Http\Request;

class DiagnosticosController extends Controller
{
    public function index()
    {
        $diagnosticos = Diagnostico::with(['paciente', 'medico'])->get();
        return response()->json($diagnosticos, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'       => 'required|date',
            'descripcion' => 'required|string',
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id'   => 'required|exists:medicos,id',
        ]);

        $diagnostico = Diagnostico::create($request->all());
        return response()->json([
            'message' => 'Diagnóstico registrado correctamente vía API.',
            'data' => $diagnostico
        ], 201);
    }

    public function show(string $id)
    {
        return response()->json(Diagnostico::with(['paciente', 'medico'])->findOrFail($id), 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'fecha' => 'required|date'
        ]);

        $diagnostico = Diagnostico::findOrFail($id);
        $diagnostico->update($request->all());

        return response()->json([
            'message' => 'Diagnóstico actualizado con éxito vía API.',
            'data' => $diagnostico
        ], 200);
    }

    public function destroy(string $id)
    {
        Diagnostico::findOrFail($id)->delete();
        return response()->json(['message' => 'Diagnóstico de la API eliminado.'], 200);
    }
}