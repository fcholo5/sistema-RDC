<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'clientes';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'email',
        'direccion',
    ];

    // Relación: un cliente puede tener muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
