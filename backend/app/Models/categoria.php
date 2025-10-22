<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención pluralizada)
    protected $table = 'categorias';

    // Permite asignación masiva solo en estos campos
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación con productos (si la tienes en la BD)
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
