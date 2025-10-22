<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;

class Productos extends RoutingController
{
    public function index()
    {
        $items = Producto::with(['categoria', 'proveedor'])->get();

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id'   => 'required|exists:categorias,id',
            'proveedor_id'   => 'required|exists:proveedores,id',
            'nombre'         => 'required|string|max:50',
            'descripcion'    => 'nullable|string|max:500',
            'cantidad'       => 'required|integer|min:0',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0',
        ]);

        try {
            $producto = Producto::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Producto creado correctamente.',
                'data' => $producto
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear producto: ' . $th->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        $producto = Producto::with(['categoria', 'proveedor'])->find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $producto
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'categoria_id'   => 'required|exists:categorias,id',
            'proveedor_id'   => 'required|exists:proveedores,id',
            'nombre'         => 'required|string|max:50',
            'descripcion'    => 'nullable|string|max:500',
            'cantidad'       => 'required|integer|min:0',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0',
        ]);

        try {
            $producto = Producto::findOrFail($id);
            $producto->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente.',
                'data' => $producto
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar producto: ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado correctamente.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar producto: ' . $th->getMessage()
            ], 500);
        }
    }
}
