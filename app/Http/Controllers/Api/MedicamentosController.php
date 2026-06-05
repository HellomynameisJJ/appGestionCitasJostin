<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicamento;

class MedicamentosController extends Controller {
    public function index() { return response()->json(Medicamento::with('tratamiento')->get(), 200); }

    public function store(Request $request) {
        $request->validate(['nombre'=>'required|string','dosis'=>'required|string','frecuencia'=>'required|string','duracion'=>'required|string','tratamiento_id'=>'required|exists:tratamientos,id','proveedor'=>'required|string','efectos_secundarios'=>'required|string']);
        $med = Medicamento::create($request->all());
        return response()->json($med, 201);
    }

    public function show(string $id) { return response()->json(Medicamento::findOrFail($id), 200); }

    public function update(Request $request, string $id) {
        $med = Medicamento::findOrFail($id);
        $med->update($request->all());
        return response()->json($med, 200);
    }

    public function destroy(string $id) {
        Medicamento::findOrFail($id)->delete();
        return response()->json(['message' => 'Medicamento eliminado'], 200);
    }
}