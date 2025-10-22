<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla si no sigue la convención (plural en inglés)
    protected $table = 'venta';

    /**
     * Campos asignables masivamente
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'cliente_id',
        'fecha',
        'total_venta',
        'metodo_de_pago',
    ];

    /**
     * Relación: una venta pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: una venta pertenece a un cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación: una venta tiene muchos detalles de venta
     */
    public function detalles()
    {
        return $this->hasMany(detalle_venta::class, 'venta_id');
    }
}
