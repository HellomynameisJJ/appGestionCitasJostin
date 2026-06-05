<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;

class CitasController extends Controller {
    public function index() { return response()->json(Cita::with(['paciente', 'medico'])->get(), 200); }

    public function store(Request $request) {
        $request->validate([
            'fecha' => 'required|date',
            'motivo' => 'required|string',
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'estado' => 'required|string'
        ]);
        $cita = Cita::create($request->all());
        return response()->json($cita, 201);
    }

    public function show(string $id) { return response()->json(Cita::with(['paciente', 'medico'])->findOrFail($id), 200); }

    public function update(Request $request, string $id) {
        $cita = Cita::findOrFail($id);
        $cita->update($request->all());
        return response()->json($cita, 200);
    }

    public function destroy(string $id) {
        Cita::findOrFail($id)->delete();
        return response()->json(['message' => 'Cita eliminada'], 200);
    }
}