<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\proveedor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;

class Proveedores extends RoutingController
{
    /**
     * Listar todos los proveedores.
     */
    public function index()
    {
        $items = proveedor::all();

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    /**
     * Almacenar un nuevo proveedor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:500',
        ]);

        try {
            $item = proveedor::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Proveedor agregado con éxito.',
                'data' => $item
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear proveedor: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un proveedor específico.
     */
    public function show(string $id)
    {
        $item = proveedor::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    /**
     * Actualizar un proveedor específico.
     */
    public function update(Request $request, string $id)
    {
        $item = proveedor::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado.'
            ], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:500',
        ]);

        try {
            $item->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Proveedor actualizado correctamente.',
                'data' => $item
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar proveedor: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un proveedor.
     */
    public function destroy(string $id)
    {
        $item = proveedor::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado.'
            ], 404);
        }

        try {
            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Proveedor eliminado correctamente.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar proveedor: ' . $th->getMessage()
            ], 500);
        }
    }
}
