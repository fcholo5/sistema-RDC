@extends('layouts.main')

@section('titulo', 'Detalles de la Compra')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Detalle de Compra</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
        <li class="breadcrumb-item active">Detalle</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body pt-4">
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
          <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($detalles as $detalle)
                <tr>
                  <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                  <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                  <td>{{ $detalle->cantidad }}</td>
                  <td>${{ number_format($detalle->sub_total, 2) }}</td>
                  <td>
                    <form action="{{ route('detalle_compra.destroy', $detalle->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este detalle?');">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i> Eliminar
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">No hay detalles para esta compra.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <a href="{{ route('compras.index') }}" class="btn btn-secondary mt-3">Volver</a>
      </div>
    </div>
  </section>
</main>
@endsection
