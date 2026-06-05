<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model {
    protected $table = 'citas';
    protected $fillable = ['fecha','motivo','paciente_id','medico_id','estado','observaciones','sala'];
    public function paciente() { return $this->belongsTo(Paciente::class, 'paciente_id'); }
    public function medico()   { return $this->belongsTo(Medico::class, 'medico_id'); }
}
