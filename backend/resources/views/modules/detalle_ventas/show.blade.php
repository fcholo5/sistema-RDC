{{-- resources/views/modules/detalle_venta/delete.blade.php --}}
@extends('layouts.main')

@section('content')
<main class="main">
    <div class="pagetitle">
        <h1>{{ $titulo }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('detalles_ventas.index') }}">Detalle de Ventas</a></li>
                <li class="breadcrumb-item active">Eliminar Detalle</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-danger">¿Está seguro que desea eliminar este detalle?</h5>

                <ul class="list-group mb-3">
                    <li class="list-group-item"><strong>ID:</strong> {{ $detalle->id }}</li>
                    <li class="list-group-item"><strong>Venta:</strong> Venta #{{ $detalle->venta->id }} - {{ $detalle->venta->fecha }}</li>
                    <li class="list-group-item"><strong>Producto:</strong> {{ $detalle->producto->nombre }}</li>
                    <li class="list-group-item"><strong>Cantidad:</strong> {{ $detalle->cantidad }}</li>
                    <li class="list-group-item"><strong>Precio Unitario:</strong> ${{ number_format($detalle->precio_unitario, 2) }}</li>
                    <li class="list-group-item"><strong>Subtotal:</strong> ${{ number_format($detalle->sub_total, 2) }}</li>
                </ul>

                <form method="POST" action="{{ route('detalles_ventas.destroy', $detalle->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    <a href="{{ route('detalles_ventas.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
