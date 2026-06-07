<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitasController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['paciente', 'medico'])->get();
        return response()->json($citas, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'       => 'required',
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id'   => 'required|exists:medicos,id',
            'motivo'      => 'required|string|max:255',
        ]);

        $cita = Cita::create($request->all());
        return response()->json([
            'message' => 'Cita registrada correctamente vía API.',
            'data' => $cita
        ], 201);
    }

    public function show(string $id)
    {
        return response()->json(Cita::with(['paciente', 'medico'])->findOrFail($id), 200);
    }

    public function update(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->update($request->all());

        return response()->json([
            'message' => 'Cita actualizada correctamente vía API.',
            'data' => $cita
        ], 200);
    }

    public function destroy(string $id)
    {
        Cita::findOrFail($id)->delete();
        return response()->json(['message' => 'Cita eliminada correctamente de la API.'], 200);
    }
}