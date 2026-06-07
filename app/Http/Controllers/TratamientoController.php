<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tratamiento;
use App\Models\Diagnostico;
use App\Models\Medico;

class TratamientoController extends Controller 
{
    public function index() 
    { 
        $tratamientos = Tratamiento::with(['diagnostico', 'medico'])->get(); 
        return view('tratamientos', compact('tratamientos')); 
    }

    public function create() 
    { 
        $diagnosticos = Diagnostico::all();
        $medicos = Medico::all();
        return view('tratamientos', compact('diagnosticos', 'medicos')); 
    }

    public function store(Request $request) 
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'duracion' => 'required|string|max:255',
            'diagnostico_id' => 'required|exists:diagnosticos,id',
            'medico_id' => 'required|exists:medicos,id',
            'estado' => 'required|string|max:255',
            'frecuencia_administracion' => 'required|string|max:255',
        ]);

        Tratamiento::create($request->all());

        return redirect()->route('tratamientos.index')->with('success', 'Plan de tratamiento registrado con éxito.');
    }

    public function edit(string $id) 
    { 
        $tratamiento = Tratamiento::findOrFail($id); 
        $diagnosticos = Diagnostico::all();
        $medicos = Medico::all();
        return view('tratamientos', compact('tratamiento', 'diagnosticos', 'medicos')); 
    }

    public function update(Request $request, string $id) 
    { 
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'duracion' => 'required|string|max:255',
            'diagnostico_id' => 'required|exists:diagnosticos,id',
            'medico_id' => 'required|exists:medicos,id',
            'estado' => 'required|string|max:255',
            'frecuencia_administracion' => 'required|string|max:255',
        ]);

        Tratamiento::findOrFail($id)->update($request->all()); 
        
        return redirect()->route('tratamientos.index')->with('success', 'Plan de tratamiento actualizado de forma correcta.'); 
    }

    public function destroy(string $id) 
    { 
        Tratamiento::findOrFail($id)->delete(); 
        return redirect()->route('tratamientos.index')->with('success', 'Tratamiento eliminado del sistema.'); 
    }
}