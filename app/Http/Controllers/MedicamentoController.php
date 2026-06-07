<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicamento;
use App\Models\Tratamiento;

class MedicamentoController extends Controller 
{
    public function index() 
    { 
        $medicamentos = Medicamento::with('tratamiento')->get(); 
        return view('medicamentos', compact('medicamentos')); 
    }

    public function create() 
    { 
        $tratamientos = Tratamiento::all(); 
        return view('medicamentos', compact('tratamientos')); 
    }

    public function store(Request $request) 
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'dosis' => 'required|string|max:255',
            'frecuencia' => 'required|string|max:255',
            'duracion' => 'required|string|max:255',
            'tratamiento_id' => 'required|exists:tratamientos,id',
            'proveedor' => 'required|string|max:255',
            'efectos_secundarios' => 'required|string'
        ]);

        Medicamento::create($request->all());

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento registrado con éxito en el inventario.');
    }

    public function show(string $id) 
    { 
        return response()->json(Medicamento::findOrFail($id)); 
    }

    public function edit(string $id) 
    { 
        $medicamento = Medicamento::findOrFail($id); 
        $tratamientos = Tratamiento::all(); 
        return view('medicamentos', compact('medicamento', 'tratamientos')); 
    }

    public function update(Request $request, string $id) 
    { 
        $request->validate([
            'nombre' => 'required|string|max:255',
            'dosis' => 'required|string|max:255',
            'frecuencia' => 'required|string|max:255',
            'duracion' => 'required|string|max:255',
            'tratamiento_id' => 'required|exists:tratamientos,id',
            'proveedor' => 'required|string|max:255',
            'efectos_secundarios' => 'required|string'
        ]);

        Medicamento::findOrFail($id)->update($request->all()); 
        
        return redirect()->route('medicamentos.index')->with('success', 'Información del medicamento actualizada correctamente.'); 
    }

    public function destroy(string $id) 
    { 
        Medicamento::findOrFail($id)->delete(); 
        return redirect()->route('medicamentos.index')->with('success', 'Medicamento removido del sistema de inventariado.'); 
    }
}