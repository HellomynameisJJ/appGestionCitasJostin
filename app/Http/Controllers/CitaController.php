<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Muestra la lista de citas y prepara los datos para el formulario.
     */
    public function index() 
    {
        // Traemos las citas con sus relaciones cargadas (optimizado)
        $citas = Cita::with(['paciente', 'medico'])->get();
        
        // Traemos los catálogos para los selects del formulario
        $pacientes = Paciente::all();
        $medicos = Medico::all();
        
        return view('citas', compact('citas', 'pacientes', 'medicos'));
    }

    /**
     * Guarda una nueva cita en la base de datos.
     */

     public function create() {
        $pacientes = \App\Models\Paciente::all();
        $medicos = \App\Models\Medico::all();
        return view('citas', compact('pacientes', 'medicos'));
    }

    public function store(Request $request) 
    {
        // Validamos que los datos lleguen bien
        $request->validate([
            'fecha' => 'required',
            'paciente_id' => 'required',
            'medico_id' => 'required',
            'motivo' => 'required'
        ]);

        Cita::create($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita registrada correctamente.');
    }

    /**
     * Actualiza una cita existente.
     */
    public function update(Request $request, $id) {
        $diagnostico = Diagnostico::findOrFail($id);
    
        // DEPURACIÓN: Si esto imprime 'null', el error es tu formulario HTML
        // dd($request->all()); 
    
        $data = $request->all();
        
        // Si la fecha llega vacía, le asignamos la fecha de hoy por defecto para que no falle
        if (empty($data['fecha'])) {
            $data['fecha'] = date('Y-m-d');
        }
    
        $diagnostico->update($data);
        return redirect()->route('diagnosticos.index')->with('success', 'Actualizado correctamente.');
    }

    /**
     * Elimina una cita.
     */
    public function destroy($id) 
    {
        Cita::findOrFail($id)->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada.');
    }
}