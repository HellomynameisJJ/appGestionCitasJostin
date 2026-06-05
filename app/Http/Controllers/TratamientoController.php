<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tratamiento;
use App\Models\Diagnostico;
use App\Models\Medico;

class TratamientoController extends Controller {
    public function index() { $tratamientos = Tratamiento::with(['diagnostico','medico'])->get(); return view('tratamientos', compact('tratamientos')); }
    public function create() { $diagnosticos = Diagnostico::all(); $medicos = Medico::all(); return view('tratamientos_create', compact('diagnosticos','medicos')); }
    public function store(Request $request) {
        $request->validate(['nombre'=>'required|string','descripcion'=>'required','duracion'=>'required|string','diagnostico_id'=>'required|exists:diagnosticos,id','medico_id'=>'required|exists:medicos,id','estado'=>'required|string','frecuencia_administracion'=>'required|string']);
        Tratamiento::create($request->all());
        return redirect()->route('tratamientos.index')->with('success','Tratamiento registrado.');
    }
    public function show(string $id) { return response()->json(Tratamiento::findOrFail($id)); }
    public function edit(string $id) { $tratamiento = Tratamiento::findOrFail($id); $diagnosticos = Diagnostico::all(); $medicos = Medico::all(); return view('tratamientos_edit', compact('tratamiento','diagnosticos','medicos')); }
    public function update(Request $request, string $id) { Tratamiento::findOrFail($id)->update($request->all()); return redirect()->route('tratamientos.index')->with('success','Tratamiento actualizado.'); }
    public function destroy(string $id) { Tratamiento::findOrFail($id)->delete(); return redirect()->route('tratamientos.index')->with('success','Tratamiento eliminado.'); }
}
