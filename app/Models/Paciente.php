<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model {
    protected $table = 'pacientes';
    protected $fillable = ['nombre','apellido','fecha_nacimiento','genero','telefono','direccion','tipo_sangre'];
    public function citas() { return $this->hasMany(Cita::class, 'paciente_id'); }
    public function diagnosticos() { return $this->hasMany(Diagnostico::class, 'paciente_id'); }
}
