@extends('layouts.admin')

@section('title', 'Gestión de Diagnósticos')

@section('content')
<div class="form-card observe" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2>{{ isset($diagnostico) ? '✏️ Editar Diagnóstico' : '➕ Nuevo Diagnóstico' }}</h2>
    
    <form method="POST" action="{{ isset($diagnostico) ? route('diagnosticos.update', $diagnostico->id) : route('diagnosticos.store') }}">
        @csrf
        @if(isset($diagnostico)) @method('PUT') @endif
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label>Fecha</label>
                <input type="date" name="fecha" value="{{ isset($diagnostico) ? date('Y-m-d', strtotime($diagnostico->fecha)) : date('Y-m-d') }}" style="width: 100%; padding: 10px;" required>
            </div>

            <div class="form-group">
                <label>Paciente</label>
                <select name="paciente_id" style="width: 100%; padding: 10px;">
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" {{ (isset($diagnostico) && $diagnostico->paciente_id == $p->id) ? 'selected' : '' }}>
                            {{ $p->nombre }} {{ $p->apellido }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Médico</label>
                <select name="medico_id" style="width: 100%; padding: 10px;">
                    @foreach($medicos as $m)
                        <option value="{{ $m->id }}" {{ (isset($diagnostico) && $diagnostico->medico_id == $m->id) ? 'selected' : '' }}>
                            {{ $m->nombre }} {{ $m->apellido }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
    <label style="font-weight: bold;">Fecha</label>
    <input type="date" 
           name="fecha" 
           value="{{ isset($diagnostico) ? date('Y-m-d', strtotime($diagnostico->fecha)) : date('Y-m-d') }}" 
           style="width: 100%; padding: 10px;" 
           required>
</div>

            <div style="grid-column: span 3;">
                <label>Descripción</label>
                <textarea name="descripcion" style="width: 100%; padding: 10px;">{{ $diagnostico->descripcion ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <input type="text" name="tipo_diagnostico" value="{{ $diagnostico->tipo_diagnostico ?? '' }}" style="width: 100%; padding: 10px;">
            </div>

            <div class="form-group">
                <label>Gravedad</label>
                <input type="text" name="gravedad" value="{{ $diagnostico->gravedad ?? '' }}" style="width: 100%; padding: 10px;">
            </div>
        </div>

        <button type="submit" style="margin-top: 20px; padding: 10px 20px; background: #2d5a27; color: white; border: none; border-radius: 6px;">
            {{ isset($diagnostico) ? 'Actualizar Cambios' : 'Registrar Diagnóstico' }}
        </button>
    </form>
</div>

<table class="data-table" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
    <thead>
        <tr style="background: #f4f4f4;">
            <th>Fecha</th><th>Paciente</th><th>Médico</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($diagnosticos as $d)
        <tr>
            <td>{{ $d->fecha }}</td>
            <td>{{ $d->paciente->nombre ?? 'N/A' }}</td>
            <td>{{ $d->medico->nombre ?? 'N/A' }}</td>
            <td><a href="{{ route('diagnosticos.index', ['edit_id' => $d->id]) }}">✏️ Editar</a></td>
        </tr>
        @empty
        <tr><td colspan="4">No hay datos.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection