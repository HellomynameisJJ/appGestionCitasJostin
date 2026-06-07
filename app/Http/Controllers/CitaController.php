<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas     = Cita::with(['paciente', 'medico'])->get();
        $pacientes = Paciente::all();
        $medicos   = Medico::all();

        return view('citas', compact('citas', 'pacientes', 'medicos'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        $medicos   = Medico::all();
        return view('citas', compact('pacientes', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'       => 'required',
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id'   => 'required|exists:medicos,id',
            'motivo'      => 'required|string|max:255',
        ]);

        Cita::create($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita registrada correctamente.');
    }

    public function show(string $id)
    {
        return response()->json(Cita::with(['paciente', 'medico'])->findOrFail($id));
    }

    public function edit(string $id)
    {
        $cita      = Cita::findOrFail($id);
        $pacientes = Paciente::all();
        $medicos   = Medico::all();
        $citas     = Cita::with(['paciente', 'medico'])->get();

        return view('citas', compact('cita', 'citas', 'pacientes', 'medicos'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'fecha'       => 'required',
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id'   => 'required|exists:medicos,id',
            'motivo'      => 'required|string|max:255',
        ]);

        $cita = Cita::findOrFail($id);
        $cita->update($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        Cita::findOrFail($id)->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada.');
    }
}