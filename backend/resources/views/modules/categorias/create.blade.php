@extends('layouts.main')

@session('titulo', $titulo)

@endsession('contenido')


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Agreagar Categoria</h1>
      <nav>
        
      </nav>
    </div><!-- End Page Title -->
     <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Agregar una nueva categoria</h5>
            <form action="{{ route('categorias.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="nombre">Nombre de categoría</label>
        <input type="text" class="form-control" name="nombre" required>
    </div>

    <div class="mb-3">
        <label for="descripcion">Descripción</label>
        <input type="text" class="form-control" name="descripcion" required>
    </div>

    <button class="btn btn-primary mt-3">Guardar</button>
    <a href="{{ route('categorias') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>

            </div>
          </div>

        </div>
      </div>
    </section>

    

  </main><!-- End #main -->


