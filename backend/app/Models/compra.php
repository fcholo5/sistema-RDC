<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = [
        'user_id',
        'productos_id',
        'cantidad',
        'precio_compra',
    ];

    // Relación: una compra pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'productos_id');
    }

    // Relación: una compra pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: una compra puede tener muchos detalles
    public function detalles()
    {
        return $this->hasMany(detalle_compra::class, 'compras_id');
    }
}
