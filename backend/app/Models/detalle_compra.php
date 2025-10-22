<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_compra extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla (opcional si ya sigue la convención)
    protected $table = 'detalle_compra';

    protected $fillable = [
        'compras_id',
        'productos_id',
        'precio_unitario',
        'cantidad',
        'sub_total',
    ];

    // Relación: cada detalle pertenece a una compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compras_id');
    }

    // Relación: cada detalle pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id');
    }
}
