<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentosController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::with('tratamiento')->get();
        return response()->json($medicamentos, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'              => 'required|string|max:255',
            'dosis'               => 'required|string|max:255',
            'frecuencia'          => 'required|string|max:255',
            'duracion'            => 'required|string|max:255',
            'tratamiento_id'      => 'required|exists:tratamientos,id',
            'proveedor'           => 'required|string|max:255',
            'efectos_secundarios' => 'required|string'
        ]);

        $medicamento = Medicamento::create($request->all());
        return response()->json([
            'message' => 'Medicamento guardado con éxito en la API.',
            'data' => $medicamento
        ], 201);
    }

    public function show(string $id)
    {
        return response()->json(Medicamento::with('tratamiento')->findOrFail($id), 200);
    }

    public function update(Request $request, string $id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->update($request->all());

        return response()->json([
            'message' => 'Medicamento actualizado correctamente vía API.',
            'data' => $medicamento
        ], 200);
    }

    public function destroy(string $id)
    {
        Medicamento::findOrFail($id)->delete();
        return response()->json(['message' => 'Medicamento eliminado de la API.'], 200);
    }
}