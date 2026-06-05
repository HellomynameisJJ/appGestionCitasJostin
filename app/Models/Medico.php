<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model {
    protected $table = 'medicos';
    protected $fillable = ['nombre','apellido','especialidad','telefono','email','licencia','anos_experiencia'];
    public function citas() { return $this->hasMany(Cita::class, 'medico_id'); }
    public function diagnosticos() { return $this->hasMany(Diagnostico::class, 'medico_id'); }
    public function tratamientos() { return $this->hasMany(Tratamiento::class, 'medico_id'); }
}
