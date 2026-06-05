<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;

class PacientesController extends Controller {
    public function index() { return response()->json(Paciente::all(), 200); }
    
    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:200',
            'tipo_sangre' => 'required|string|max:5',
        ]);
        $paciente = Paciente::create($request->all());
        return response()->json($paciente, 201);
    }

    public function show(string $id) { return response()->json(Paciente::findOrFail($id), 200); }
    
    public function update(Request $request, string $id) {
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());
        return response()->json($paciente, 200);
    }

    public function destroy(string $id) {
        Paciente::findOrFail($id)->delete();
        return response()->json(['message' => 'Eliminado correctamente'], 200);
    }
}