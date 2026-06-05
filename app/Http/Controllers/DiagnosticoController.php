<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function index(Request $request) {
        $diagnosticos = Diagnostico::with(['paciente', 'medico'])->get();
        $pacientes = Paciente::all();
        $medicos = Medico::all();
        
        $diagnostico = null;
        if ($request->has('edit_id')) {
            $diagnostico = Diagnostico::findOrFail($request->edit_id);
        }
        
        return view('diagnosticos', compact('diagnosticos', 'pacientes', 'medicos', 'diagnostico'));
    }

    public function store(Request $request) {
        $request->validate(['fecha' => 'required|date']);
        Diagnostico::create($request->all());
        return redirect()->route('diagnosticos.index')->with('success', 'Registrado con éxito.');
    }

    public function update(Request $request, $id) {
        $diagnostico = Diagnostico::findOrFail($id);
        // Validamos la fecha para evitar el error de columna nula
        $request->validate(['fecha' => 'required|date']);
        $diagnostico->update($request->all());
        return redirect()->route('diagnosticos.index')->with('success', 'Actualizado con éxito.');
    }
}