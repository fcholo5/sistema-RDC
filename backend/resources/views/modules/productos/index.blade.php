@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Productos</h1>
    <nav></nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar productos</h5>
            <p>Administra los productos registrados en el sistema</p>

            <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">
              <i class="fa-solid fa-circle-plus"></i> Agregar un nuevo producto
            </a>

            <table class="table table-striped table-bordered datatables text-center">
              <thead class="table-dark">
                <tr>
                  <th>Categoría</th>
                  <th>Proveedor</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Cantidad</th>
                  <th>Precio Compra</th>
                  <th>Precio Venta</th>
                  <th>Acciones</th>

                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  <tr>
                    <td>{{ $item->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $item->proveedor->nombre ?? 'Sin proveedor' }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>${{ number_format($item->precio_compra, 2) }}</td>
                    <td>${{ number_format($item->precio_venta, 2) }}</td>
                    <td>
                      <a href="{{ route('compras.create', $item->id) }}" class="btn btn-info">Comprar</a>
                    </td>
                    <td>
                      <a href="{{ route('productos.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Editar">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <form action="{{ route('productos.destroy', $item->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar producto?')" title="Eliminar">
                          <i class="fa-solid fa-trash-can"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>

      </div>
    </div>
  </section>
</main>
@endsection
