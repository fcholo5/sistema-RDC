@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Crear Producto</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Crear nuevo producto</h5>

                        <form action="{{ route('productos.store') }}" method="POST">
                            @csrf

                            {{-- Categoría --}}
                            <div class="mb-3">
                                <label for="categoria_id">Categoría</label>
                                <select name="categoria_id" class="form-control" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Proveedor --}}
                            <div class="mb-3">
                                <label for="proveedor_id">Proveedor</label>
                                <select name="proveedor_id" class="form-control" required>
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Nombre --}}
                            <div class="mb-3">
                                <label for="nombre">Nombre del producto</label>
                                <input type="text" name="nombre" class="form-control" maxlength="50" required>
                            </div>

                            {{-- Descripción --}}
                            <div class="mb-3">
                                <label for="descripcion">Descripción</label>
                                <input type="text" name="descripcion" class="form-control" maxlength="500">
                            </div>

                            {{-- Cantidad --}}
                            <div class="mb-3">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" min="0" value="0" required>
                            </div>

                            {{-- Precio de Compra --}}
                            <div class="mb-3">
                                <label for="precio_compra">Precio de Compra</label>
                                <input type="number" name="precio_compra" class="form-control" step="0.01" min="0" value="0.00" required>
                            </div>

                            {{-- Precio de Venta --}}
                            <div class="mb-3">
                                <label for="precio_venta">Precio de Venta</label>
                                <input type="number" name="precio_venta" class="form-control" step="0.01" min="0" value="0.00" required>
                            </div>

                            {{-- Botones --}}
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('productos') }}" class="btn btn-secondary">Cancelar</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
