<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_venta extends Model
{
    use HasFactory;

    // Tabla explícita (opcional si sigues la convención)
    protected $table = 'detalle_venta';

    protected $fillable = [
        'venta_id',
        'productos_id',
        'precio_unitario',
        'cantidad',
        'sub_total',
    ];

    // Relación: este detalle pertenece a una venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    // Relación: este detalle pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id');
    }
}
