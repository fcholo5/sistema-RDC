{{-- resources/views/modules/detalle_venta/index.blade.php --}}
@extends('layouts.main')

@section('content')
<main class="main">
    <div class="pagetitle">
        <h1>{{ $titulo }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('detalles_ventas.index') }}">Detalle de Ventas</a></li>
                <li class="breadcrumb-item active">Agregar Detalle</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nuevo Detalle de Venta</h5>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('detalles_ventas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="venta_id" class="form-label">Venta</label>
                        <select name="venta_id" id="venta_id" class="form-select" required>
                            <option value="">Seleccione una venta</option>
                            @foreach ($ventas as $venta)
                                <option value="{{ $venta->id }}" {{ old('venta_id') == $venta->id ? 'selected' : '' }}>
                                    Venta #{{ $venta->id }} - {{ $venta->fecha }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="productos_id" class="form-label">Producto</label>
                        <select name="productos_id" id="productos_id" class="form-select" required>
                            <option value="">Seleccione un producto</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}" {{ old('productos_id') == $producto->id ? 'selected' : '' }}>
                                    {{ $producto->nombre }} (Stock: {{ $producto->cantidad }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" step="0.01" min="0.01" value="{{ old('cantidad') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="precio_unitario" class="form-label">Precio Unitario</label>
                        <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" step="0.01" min="0" value="{{ old('precio_unitario') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Registrar Detalle</button>
                    <a href="{{ route('detalles_ventas.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
