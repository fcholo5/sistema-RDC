@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Editar Producto</h1>
      <nav></nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Editar producto</h5>

              <form action="{{ route('productos.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Categoría --}}
                <div class="mb-3">
                  <label for="categoria_id">Categoría</label>
                  <select name="categoria_id" class="form-control" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $categoria)
                      <option value="{{ $categoria->id }}" {{ $item->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- Proveedor --}}
                <div class="mb-3">
                  <label for="proveedor_id">Proveedor</label>
                  <select name="proveedor_id" class="form-control" required>
                    <option value="">Seleccione un proveedor</option>
                    @foreach ($proveedores as $proveedor)
                      <option value="{{ $proveedor->id }}" {{ $item->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- Nombre --}}
                <div class="mb-3">
                  <label for="nombre">Nombre del producto</label>
                  <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $item->nombre }}" required>
                </div>

                {{-- Descripción --}}
                <div class="mb-3">
                  <label for="descripcion">Descripción</label>
                  <input type="text" class="form-control" name="descripcion" value="{{ $item->descripcion }}">
                </div>

                {{-- Cantidad --}}
                <div class="mb-3">
                  <label for="cantidad">Cantidad</label>
                  <input type="number" class="form-control" name="cantidad" value="{{ $item->cantidad }}" required>
                </div>

                {{-- Precio de compra --}}
                <div class="mb-3">
                  <label for="precio_compra">Precio de compra</label>
                  <input type="number" step="0.01" class="form-control" name="precio_compra" value="{{ $item->precio_compra }}" required>
                </div>

                {{-- Precio de venta --}}
                <div class="mb-3">
                  <label for="precio_venta">Precio de venta</label>
                  <input type="number" step="0.01" class="form-control" name="precio_venta" value="{{ $item->precio_venta }}" required>
                </div>

                <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
                <a href="{{ route('productos') }}" class="btn btn-secondary mt-3">Cancelar</a>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>
</main>
@endsection
