<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medico;
use Illuminate\Http\Request;

class MedicosController extends Controller
{
    public function index()
    {
        return response()->json(Medico::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'apellido'     => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
        ]);

        $medico = Medico::create($request->all());
        return response()->json([
            'message' => 'Médico registrado correctamente vía API.',
            'data' => $medico
        ], 201);
    }

    public function show(string $id)
    {
        return response()->json(Medico::findOrFail($id), 200);
    }

    public function update(Request $request, string $id)
    {
        $medico = Medico::findOrFail($id);
        $medico->update($request->all());
        return response()->json([
            'message' => 'Médico actualizado correctamente vía API.',
            'data' => $medico
        ], 200);
    }

    public function destroy(string $id)
    {
        Medico::findOrFail($id)->delete();
        return response()->json(['message' => 'Médico eliminado correctamente de la API.'], 200);
    }
}