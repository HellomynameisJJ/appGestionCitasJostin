<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicamento;
use App\Models\Tratamiento;

class MedicamentoController extends Controller {
    public function index() { $medicamentos = Medicamento::with('tratamiento')->get(); return view('medicamentos', compact('medicamentos')); }
    public function create() { $tratamientos = Tratamiento::all(); return view('medicamentos_create', compact('tratamientos')); }
    public function store(Request $request) {
        $request->validate(['nombre'=>'required|string','dosis'=>'required|string','frecuencia'=>'required|string','duracion'=>'required|string','tratamiento_id'=>'required|exists:tratamientos,id','proveedor'=>'required|string','efectos_secundarios'=>'required|string']);
        Medicamento::create($request->all());
        return redirect()->route('medicamentos.index')->with('success','Medicamento registrado.');
    }
    public function show(string $id) { return response()->json(Medicamento::findOrFail($id)); }
    public function edit(string $id) { $medicamento = Medicamento::findOrFail($id); $tratamientos = Tratamiento::all(); return view('medicamentos_edit', compact('medicamento','tratamientos')); }
    public function update(Request $request, string $id) { Medicamento::findOrFail($id)->update($request->all()); return redirect()->route('medicamentos.index')->with('success','Medicamento actualizado.'); }
    public function destroy(string $id) { Medicamento::findOrFail($id)->delete(); return redirect()->route('medicamentos.index')->with('success','Medicamento eliminado.'); }
}
