<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'direccion',
    ];

    // Relación: un proveedor puede tener muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'proveedor_id');
    }
}
