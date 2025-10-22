<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\detalle_venta;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class detalle_ventas extends RoutingController
{
    public function index()
    {
        $items = detalle_venta::with(['venta', 'producto'])->get();
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:venta,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $venta = Venta::findOrFail($request->venta_id);
            $producto = Producto::findOrFail($request->producto_id);

            if ($producto->cantidad < $request->cantidad) {
                return response()->json(['success' => false, 'message' => 'Stock insuficiente.'], 422);
            }

            $subtotal = $request->cantidad * $request->precio_unitario;

            $detalle = detalle_venta::create([
                'venta_id' => $request->venta_id,
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'subtotal' => $subtotal,
            ]);

            $producto->cantidad -= $request->cantidad;
            $producto->save();

            $venta->total_venta += $subtotal;
            $venta->save();

            DB::commit();
            return response()->json(['success' => true, 'data' => $detalle]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al agregar detalle: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al agregar detalle.'], 500);
        }
    }

    public function show($id)
    {
        $item = detalle_venta::with(['venta', 'producto'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $detalle = detalle_venta::findOrFail($id);
            $venta = Venta::findOrFail($detalle->venta_id);

            $productoAnterior = Producto::findOrFail($detalle->producto_id);
            $productoAnterior->cantidad += $detalle->cantidad;
            $productoAnterior->save();

            $productoNuevo = Producto::findOrFail($request->producto_id);
            if ($productoNuevo->cantidad < $request->cantidad) {
                return response()->json(['success' => false, 'message' => 'Stock insuficiente.'], 422);
            }

            $nuevoSubtotal = $request->cantidad * $request->precio_unitario;

            $detalle->update([
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'subtotal' => $nuevoSubtotal,
            ]);

            $productoNuevo->cantidad -= $request->cantidad;
            $productoNuevo->save();

            $venta->total_venta = ($venta->total_venta - $detalle->subtotal) + $nuevoSubtotal;
            $venta->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Detalle actualizado correctamente']);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar detalle: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar detalle.'], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $detalle = detalle_venta::findOrFail($id);
            $venta = Venta::findOrFail($detalle->venta_id);

            $producto = Producto::findOrFail($detalle->producto_id);
            $producto->cantidad += $detalle->cantidad;
            $producto->save();

            $venta->total_venta -= $detalle->subtotal;
            $venta->save();

            $detalle->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Detalle eliminado correctamente']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar detalle: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'No se pudo eliminar el detalle.'], 500);
        }
    }
}
