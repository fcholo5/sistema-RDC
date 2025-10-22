<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;

class Dashboard extends RoutingController
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Bienvenido al panel de control de la API',
            'data' => [
                'usuarios' => route('api.usuarios.index'),
                'productos' => route('api.productos.index'),
                'ventas' => route('api.ventas.index'),
                'compras' => route('api.compras.index'),
            ]
        ]);
    }
}
