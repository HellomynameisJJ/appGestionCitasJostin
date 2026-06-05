<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medico;

class MedicosController extends Controller {
    public function index() { return response()->json(Medico::all(), 200); }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'especialidad' => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:150',
            'licencia' => 'required|string|max:50',
            'anos_experiencia' => 'required|integer|min:0',
        ]);
        $medico = Medico::create($request->all());
        return response()->json($medico, 201);
    }

    public function show(string $id) { return response()->json(Medico::findOrFail($id), 200); }

    public function update(Request $request, string $id) {
        $medico = Medico::findOrFail($id);
        $medico->update($request->all());
        return response()->json($medico, 200);
    }

    public function destroy(string $id) {
        Medico::findOrFail($id)->delete();
        return response()->json(['message' => 'Eliminado correctamente'], 200);
    }
}