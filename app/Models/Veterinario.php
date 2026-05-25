<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veterinario extends Model
{
    use SoftDeletes;

    protected $table = 'veterinarios';

    protected $fillable = [
        'usuario_id',
        'nombre_completo',
        'especialidad',
        'cedula_profesional',
        'foto_firma',
        'telefono',
        'anio_antiguedad',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
