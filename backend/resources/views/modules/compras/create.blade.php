@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>{{ $titulo }}</h1>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">compra nueva </h5>

                <form action="{{ route('compras.store') }}" method="POST">
                    @csrf
                        <div class="mb-3">
                        <label for="producto_id">ID del Producto</label>
                        <input type="text" name="producto_id" class="form-control" value="{{ $id_producto }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio_compra">Precio de compra</label>
                        <input type="number" name="precio_compra" class="form-control" min="1" required>
                    </div>

                    {{-- Botón --}}
                    <button type="submit" class="btn btn-primary">Registrar Compra</button>
                    <a href="{{ route('productos') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
