<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'proveedor_id',
        'nombre',
        'descripcion',
        'cantidad',
        'precio_compra',
        'precio_venta',
    ];

    // Relación: este producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación: este producto pertenece a un proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // Relación con DetalleCompra (opcional)
    public function detallesCompra()
    {
        return $this->hasMany(detalle_compra::class, 'productos_id');
    }

    // Relación con DetalleVenta (opcional)
    public function detallesVenta()
    {
        return $this->hasMany(detalle_venta::class, 'productos_id');
    }
}
