@extends('layouts.main')

@section('titulo', 'Registrar Venta')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Registrar Venta</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('venta.index') }}">Ventas</a></li>
        <li class="breadcrumb-item active">Registrar</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Factura - Usuario: <strong>{{ $usuario->name }}</strong></h5>

        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('venta.store') }}" method="POST" id="ventaForm">
          @csrf

          {{-- Cliente y método de pago --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="cliente_id" class="form-label">Cliente (opcional)</label>
              <select name="cliente_id" class="form-select">
                <option value="">Seleccione</option>
                @foreach ($clientes as $cliente)
                  <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="metodo_de_pago" class="form-label">Método de Pago</label>
              <select name="metodo_de_pago" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Transferencia">Transferencia</option>
              </select>
            </div>
          </div>

          {{-- Selección de producto --}}
          <div class="row align-items-end mb-3">
            <div class="col-md-5">
              <label class="form-label">Producto</label>
              <select id="producto_id" class="form-select">
                <option value="">Seleccione un producto</option>
                @foreach ($productos as $producto)
                  <option value="{{ $producto->id }}"
                          data-nombre="{{ $producto->nombre }}"
                          data-stock="{{ $producto->cantidad }}"
                          data-precio="{{ $producto->precio_venta }}">
                    {{ $producto->nombre }} (Stock: {{ $producto->cantidad }})
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">Cantidad</label>
              <input type="number" min="1" id="cantidad" class="form-control" value="1">
            </div>
            <div class="col-md-2">
              <button type="button" id="agregar" class="btn btn-success w-100">
                <i class="bi bi-plus-circle"></i> Agregar
              </button>
            </div>
          </div>

          {{-- Tabla de productos --}}
          <div class="table-responsive mb-3">
            <table class="table table-bordered text-center align-middle" id="tabla-productos">
              <thead class="table-dark">
                <tr>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th>Cantidad</th>
                  <th>Subtotal</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-end">Total:</th>
                  <th id="total">0.00</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>

          {{-- Botón de guardar --}}
          <div class="text-end">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save"></i> Guardar Venta
            </button>
            <a href="{{ route('venta.index') }}" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

{{-- JavaScript --}}
<script>
  const btnAgregar = document.getElementById('agregar');
  const tabla = document.querySelector('#tabla-productos tbody');
  const total = document.getElementById('total');
  let totalVenta = 0;

  btnAgregar.addEventListener('click', () => {
    const select = document.getElementById('producto_id');
    const selected = select.options[select.selectedIndex];
    const id = selected.value;
    const nombre = selected.dataset.nombre;
    const precio = parseFloat(selected.dataset.precio);
    const stock = parseInt(selected.dataset.stock);
    const cantidad = parseInt(document.getElementById('cantidad').value);

    if (!id || cantidad < 1 || cantidad > stock) {
      alert("Verifique el producto y la cantidad disponible.");
      return;
    }

    const subtotal = precio * cantidad;
    totalVenta += subtotal;

    const fila = document.createElement('tr');
    fila.innerHTML = `
      <td>${nombre}<input type="hidden" name="productos_id[]" value="${id}"></td>
      <td>${precio.toFixed(2)}<input type="hidden" name="precios[]" value="${precio}"></td>
      <td>${cantidad}<input type="hidden" name="cantidades[]" value="${cantidad}"></td>
      <td>${subtotal.toFixed(2)}</td>
      <td><button type="button" class="btn btn-danger btn-sm eliminar">X</button></td>
    `;
    tabla.appendChild(fila);

    total.textContent = totalVenta.toFixed(2);
    select.selectedIndex = 0;
    document.getElementById('cantidad').value = 1;

    fila.querySelector('.eliminar').addEventListener('click', () => {
      totalVenta -= subtotal;
      fila.remove();
      total.textContent = totalVenta.toFixed(2);
    });
  });
</script>
@endsection
