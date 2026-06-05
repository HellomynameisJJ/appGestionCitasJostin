<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function index(Request $request) {
        $diagnosticos = Diagnostico::all();
        $pacientes = Paciente::all();
        $medicos = Medico::all();
        
        $diagnostico = null;
        if ($request->has('edit_id')) {
            $diagnostico = Diagnostico::find($request->edit_id);
        }
        
        return view('diagnosticos', compact('diagnosticos', 'pacientes', 'medicos', 'diagnostico'));
    }

    public function store(Request $request) {
        $request->validate([
            'fecha' => 'required|date',
            'paciente_id' => 'required',
            'medico_id' => 'required',
            'tipo' => 'required',
            'gravedad' => 'required'
        ]);

        Diagnostico::create($request->all());
        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico registrado.');
    }

    public function update(Request $request, $id) {
        $diagnostico = Diagnostico::findOrFail($id);
        $diagnostico->update($request->all());
        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico actualizado.');
    }
}