@extends('layouts.main')

@session('titulo', $titulo)

@endsession('contenido')


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Agreagar proveedor</h1>
      <nav>
        
      </nav>
    </div><!-- End Page Title -->
     <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Agregar un nuevo proveedor</h5>
            <form action="{{ route('proveedores.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="nombre">Nombre de proveedor</label>
        <input type="text" class="form-control" name="nombre" required>
        <label for="telefon">Telefono</label>
        <input type="text" class="form-control" name="telefono" required>
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" required>
        <label for="direccion">Direccion</label>
        <input type="text" class="form-control" name="direccion" required>
    </div>
    <button class="btn btn-primary mt-3">Guardar</button>
    <a href="{{ route('proveedores') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>

            </div>
          </div>

        </div>
      </div>
    </section>

    

  </main><!-- End #main -->


