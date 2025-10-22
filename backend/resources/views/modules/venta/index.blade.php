@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ $titulo }}</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Listado de Ventas</h5>
                        <p>Aquí puedes ver todas las ventas registradas en el sistema.</p>

                        {{-- Alertas --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        @endif

                        {{-- Botón Nueva Venta --}}
                        <a href="{{ route('venta.create') }}" class="btn btn-primary mb-3">
                            <i class="fa-solid fa-circle-plus"></i> Registrar Nueva Venta
                        </a>

                        <table class="table table-striped table-bordered datatables text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Método de Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->cliente->nombre ?? 'Sin cliente' }}</td>
                                        <td>{{ $venta->user->name ?? 'Desconocido' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</td>
                                        <td>${{ number_format($venta->total_venta, 2) }}</td>
                                        <td>{{ ucfirst($venta->metodo_de_pago) }}</td>
                                        <td>
                                            <a href="{{ route('venta.show', $venta->id) }}" class="btn btn-info btn-sm" title="Ver Detalles">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <form action="{{ route('venta.destroy', $venta->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta venta?')" title="Eliminar">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No hay ventas registradas.</td>
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
