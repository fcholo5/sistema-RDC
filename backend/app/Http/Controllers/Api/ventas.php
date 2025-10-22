<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\detalle_venta;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Ventas extends RoutingController
{
    /**
     * Listar todas las ventas con cliente y usuario.
     */
    public function index()
    {
        $ventas = Venta::with(['cliente', 'user'])->get();

        return response()->json([
            'success' => true,
            'data' => $ventas
        ]);
    }

    /**
     * Registrar una nueva venta.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'cliente_id'       => 'nullable|exists:clientes,id',
    //         'productos_id'     => 'required|array',
    //         'productos_id.*'   => 'exists:productos,id',
    //         'cantidades'       => 'required|array',
    //         'cantidades.*'     => 'numeric|min:1',
    //         'precios'          => 'required|array',
    //         'precios.*'        => 'numeric|min:0',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $userId = Auth::id();
    //         if (!$userId) {
    //             throw new \Exception('Usuario no autenticado');
    //         }

    //         $totalVenta = 0;

    //         foreach ($request->productos_id as $i => $productoId) {
    //             $cantidad = $request->cantidades[$i];
    //             $precio   = $request->precios[$i];
    //             $totalVenta += $precio * $cantidad;
    //         }

    //         $venta = Venta::create([
    //             'user_id'        => $userId,
    //             'cliente_id'     => $request->cliente_id,
    //             'fecha'          => now(),
    //             'total_venta'    => $totalVenta,
    //             'metodo_de_pago' => $request->metodo_de_pago,
    //         ]);

    //         foreach ($request->productos_id as $i => $productoId) {
    //             $cantidad = $request->cantidades[$i];
    //             $precio   = $request->precios[$i];
    //             $subtotal = $precio * $cantidad;

    //             $producto = Producto::findOrFail($productoId);

    //             if ($producto->cantidad < $cantidad) {
    //                 DB::rollBack();
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => "Stock insuficiente para el producto: {$producto->nombre}."
    //                 ], 400);
    //             }

    //             detalle_venta::create([
    //                 'venta_id'        => $venta->id,
    //                 'productos_id'    => $productoId,
    //                 'precio_unitario' => $precio,
    //                 'cantidad'        => $cantidad,
    //                 'sub_total'       => $subtotal,
    //             ]);

    //             $producto->cantidad -= $cantidad;
    //             $producto->save();
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Venta registrada correctamente.',
    //             'venta' => $venta->load('cliente', 'user')
    //         ]);

    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Log::error("Error al registrar venta: " . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al registrar la venta.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'         => 'nullable|exists:clientes,id',
            'metodo_de_pago'     => 'required|string|max:50',
            'productos'          => 'required|array|min:1',
            'productos.*.id'     => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio'   => 'required|numeric|min:0',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        DB::beginTransaction();

        try {
            $totalVenta = 0;

            // Validar stock antes de registrar la venta
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);
                if ($producto->cantidad < $item['cantidad']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stock insuficiente para el producto: {$producto->nombre}."
                    ], 400);
                }
                $totalVenta += $item['precio'] * $item['cantidad'];
            }

            $venta = Venta::create([
                'user_id'        => $userId,
                'cliente_id'     => $request->cliente_id,
                'fecha'          => now(),
                'total_venta'    => $totalVenta,
                'metodo_de_pago' => $request->metodo_de_pago,
            ]);

            foreach ($request->productos as $item) {
                $subtotal = $item['precio'] * $item['cantidad'];

                detalle_venta::create([
                    'venta_id'        => $venta->id,
                    'productos_id'    => $item['id'],
                    'precio_unitario' => $item['precio'],
                    'cantidad'        => $item['cantidad'],
                    'sub_total'       => $subtotal,
                ]);

                // Actualizar stock
                Producto::where('id', $item['id'])->decrement('cantidad', $item['cantidad']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada correctamente.',
                'venta'   => $venta->load('cliente', 'user'),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al registrar venta: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la venta.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Eliminar una venta y restaurar stock.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $venta = Venta::with('detalles')->findOrFail($id);

            foreach ($venta->detalles as $detalle) {
                $producto = Producto::findOrFail($detalle->productos_id);
                $producto->cantidad += $detalle->cantidad;
                $producto->save();

                $detalle->delete();
            }

            $venta->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venta eliminada correctamente.'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar venta: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la venta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
