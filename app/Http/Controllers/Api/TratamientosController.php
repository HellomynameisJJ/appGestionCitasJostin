<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tratamiento;

class TratamientosController extends Controller {
    public function index() { return response()->json(Tratamiento::with(['diagnostico', 'medico'])->get(), 200); }

    public function store(Request $request) {
        $request->validate(['nombre'=>'required|string','descripcion'=>'required','duracion'=>'required|string','diagnostico_id'=>'required|exists:diagnosticos,id','medico_id'=>'required|exists:medicos,id','estado'=>'required|string','frecuencia_administracion'=>'required|string']);
        $trat = Tratamiento::create($request->all());
        return response()->json($trat, 201);
    }

    public function show(string $id) { return response()->json(Tratamiento::findOrFail($id), 200); }

    public function update(Request $request, string $id) {
        $trat = Tratamiento::findOrFail($id);
        $trat->update($request->all());
        return response()->json($trat, 200);
    }

    public function destroy(string $id) {
        Tratamiento::findOrFail($id)->delete();
        return response()->json(['message' => 'Tratamiento eliminado'], 200);
    }
}