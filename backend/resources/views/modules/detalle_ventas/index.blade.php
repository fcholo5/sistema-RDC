@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ $titulo }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('venta.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Detalles de Ventas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Listado de Detalles de Ventas</h5>
                        <p>Aquí puedes ver todos los productos vendidos en cada venta registrada.</p>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table class="table table-striped table-bordered datatables text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Fecha Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td>{{ $item->venta->id }}</td>
                                        <td>{{ $item->producto->nombre ?? 'Producto Desconocido' }}</td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>${{ number_format($item->precio_unitario, 2) }}</td>
                                        <td>${{ number_format($item->sub_total, 2) }}</td>
                                        <td>{{ $item->venta->cliente->nombre ?? 'No registrado' }}</td>
                                        <td>{{ $item->venta->user->name ?? 'Desconocido' }}</td>
                                        <td>{{ $item->venta->fecha ? \Carbon\Carbon::parse($item->venta->fecha)->format('d/m/Y H:i') : 'No disponible' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No hay ventas registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection
