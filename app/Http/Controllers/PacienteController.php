<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Paciente;

class PacienteController extends Controller {
    public function index() {
        $pacientes = Paciente::all();
        return view('pacientes', compact('pacientes'));
    }
    public function create() { return view('pacientes_create'); }
    public function store(Request $request) {
        $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'genero'           => 'required|string',
            'telefono'         => 'required|string|max:20',
            'direccion'        => 'required|string|max:200',
            'tipo_sangre'      => 'required|string|max:5',
        ]);
        Paciente::create($request->all());
        return redirect()->route('pacientes.index')->with('success','Paciente registrado correctamente.');
        // Obtenemos todos los pacientes para listarlos
    $pacientes = \App\Models\Paciente::latest()->get(); 
    
    // Enviamos la variable a la vista create
    return view('pacientes.create', compact('pacientes'));
    }
    public function show(string $id) { return response()->json(Paciente::findOrFail($id)); }
    public function edit(string $id) { $paciente = Paciente::findOrFail($id); return view('pacientes_edit', compact('paciente')); }
    public function update(Request $request, string $id) {
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());
        return redirect()->route('pacientes.index')->with('success','Paciente actualizado.');
    }
    public function destroy(string $id) {
        Paciente::findOrFail($id)->delete();
        return redirect()->route('pacientes.index')->with('success','Paciente eliminado.');
    }
}