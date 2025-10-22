@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Eliminar Producto</h1>
        <nav></nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-danger">¿Estás seguro de eliminar este producto?</h5>

                        <form action="{{ route('productos.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <fieldset disabled>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del producto</label>
                                    <input type="text" class="form-control" value="{{ $item->nombre }}">
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <input type="text" class="form-control" value="{{ $item->descripcion }}">
                                </div>
                            </fieldset>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can"></i> Eliminar
                                </button>
                                <a href="{{ route('productos') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-circle-xmark"></i> Cancelar
                                </a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection
