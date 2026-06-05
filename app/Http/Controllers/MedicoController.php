<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function index() {
        $medicos = \App\Models\Medico::all();
        return view('medicos', compact('medicos'));
    }
    
    public function store(Request $request) {
        // Esto guarda todo lo que venga del formulario
        \App\Models\Medico::create($request->all());
        return redirect()->route('medicos.index')->with('success', 'Médico registrado');
}
    public function show(string $id) { 
        return response()->json(Medico::findOrFail($id)); 
    }
    public function edit($id)
{
    $cita = \App\Models\Cita::findOrFail($id);
    $pacientes = \App\Models\Paciente::all();
    $medicos = \App\Models\Medico::all();
    
    // Asegúrate de que este archivo exista
    return view('citas.edit', compact('cita', 'pacientes', 'medicos'));
}

public function update(Request $request, $id)
{
    $cita = \App\Models\Cita::findOrFail($id);
    $cita->update($request->all());
    
    return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }
    public function destroy(string $id) { Medico::findOrFail($id)->delete(); return redirect()->route('medicos.index')->with('success','Médico eliminado.'); }
}
