@extends('layouts.admin')

@section('title', 'Admisión - CliniSync')
@section('hero_icon', '👤')
@section('hero_title', 'Registro de Pacientes | CliniSync')
@section('hero_subtitle', 'Incorporar nuevos usuarios al ecosistema clínico de CliniSync')

@section('content')
<div class="form-card observe">
    <form method="POST" action="{{ route('pacientes.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nombres</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej. Juan Carlos" required>
            </div>
            <div class="form-group">
                <label>Apellidos</label>
                <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" placeholder="Ej. Pérez Salazar" required>
            </div>
            <div class="form-group">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" required>
            </div>
            <div class="form-group">
                <label>Género</label>
                <select name="genero" class="form-control">
                    <option value="">Seleccionar identidad...</option>
                    <option value="masculino" {{ old('genero')=='masculino'?'selected':'' }}>Masculino</option>
                    <option value="femenino"  {{ old('genero')=='femenino' ?'selected':'' }}>Femenino</option>
                    <option value="otro"      {{ old('genero')=='otro'     ?'selected':'' }}>Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label>Contacto Telefónico</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" placeholder="Ej. 999 111 222">
            </div>
            <div class="form-group">
                <label>Grupo Sanguíneo</label>
                <select name="tipo_sangre" class="form-control">
                    <option value="">Seleccionar grupo...</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $ts)
                    <option value="{{ $ts }}" {{ old('tipo_sangre')==$ts?'selected':'' }}>{{ $ts }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-full">
                <label>Domicilio Actual</label>
                <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" placeholder="Ej. Av. Los Próceres 123, Urb. San Juan">
            </div>
        </div>
        <div class="form-actions" style="margin-top: 1.5rem;">
            <a href="{{ route('pacientes.index') }}" class="btn-cancel">Descartar</a>
            <button type="submit" class="btn-submit">💾 Registrar en CliniSync</button>
        </div>
    </form>
</div>

<div class="table-card observe" style="margin-top: 2rem;">
    <h2>Censo de Pacientes - CliniSync</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Código ID</th>
                <th>Paciente</th>
                <th>Nacimiento</th>
                <th>Género</th>
                <th>Contacto</th>
                <th>Factor Sanguíneo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pacientes as $p)
            <tr>
                <td><span class="row-id">PAT-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                <td><strong>{{ $p->nombre }} {{ $p->apellido }}</strong></td>
                <td>📅 {{ \Carbon\Carbon::parse($p->fecha_nacimiento)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($p->genero) }}</td>
                <td>📞 {{ $p->telefono ?? '—' }}</td>
                <td><span class="badge-dosis">🩸 {{ $p->tipo_sangre ?? 'N/A' }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px; font-style: italic;">
                    No existen pacientes registrados en CliniSync actualmente.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection