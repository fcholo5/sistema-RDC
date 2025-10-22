<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\detalle_compra;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class detalle_compras extends RoutingController
{
    /**
     * Mostrar detalles de una compra específica.
     */
    public function showByCompra($compraId)
    {
        $detalles = detalle_compra::with('producto')->where('compras_id', $compraId)->get();

        return response()->json([
            'success' => true,
            'data' => $detalles
        ]);
    }

    /**
     * Eliminar un detalle de compra individualmente (y ajustar el stock).
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $detalle = detalle_compra::findOrFail($id);
            $producto = Producto::findOrFail($detalle->productos_id);

            // Devolver stock al producto
            $producto->cantidad -= $detalle->cantidad;
            $producto->save();

            $detalle->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Detalle eliminado y stock ajustado correctamente.'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar detalle de compra: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar el detalle.'
            ], 500);
        }
    }
}
