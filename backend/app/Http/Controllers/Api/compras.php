<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Routing\Controller as RoutingController;

class Compras extends RoutingController
{
    public function index()
    {
        $compras = Compra::with('producto')->get();

        return response()->json([
            'success' => true,
            'data' => $compras
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        try {
            $compra = Compra::create([
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'sub_total' => $request->cantidad * $request->precio_unitario,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Compra registrada correctamente.',
                'data' => $compra
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la compra.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        $compra = Compra::with('producto')->find($id);

        if (!$compra) {
            return response()->json([
                'success' => false,
                'message' => 'Compra no encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $compra
        ]);
    }

    public function update(Request $request, string $id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return response()->json([
                'success' => false,
                'message' => 'Compra no encontrada.'
            ], 404);
        }

        $request->validate([
            'cantidad' => 'sometimes|integer|min:1',
            'precio_unitario' => 'sometimes|numeric|min:0',
        ]);

        $compra->update($request->all());
        $compra->sub_total = $compra->cantidad * $compra->precio_unitario;
        $compra->save();

        return response()->json([
            'success' => true,
            'message' => 'Compra actualizada correctamente.',
            'data' => $compra
        ]);
    }

    public function destroy(string $id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return response()->json([
                'success' => false,
                'message' => 'Compra no encontrada.'
            ], 404);
        }

        $compra->delete();

        return response()->json([
            'success' => true,
            'message' => 'Compra eliminada correctamente.'
        ]);
    }
}
