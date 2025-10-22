@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Categorías</h1>
    <nav></nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar categorias</h5>
            <p>
              Adminstrar la categorias de productos
            </p>
            <!-- Table with stripped rows -->

            <a href="{{ route('categorias.create') }}" class="btn btn-primary"> 
              <i class="fa-solid fa-circle-plus"></i>Agregar nueva categoria
            </a>
            <hr>
            <table class="table datables text-center">

              <thead>
                <tr>
                  <th>Nombre categorías</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                 @foreach ($items  as $item )                 
                  <tr>
                    <td>{{ $item->nombre }}</td>
                    <td>
                      <a href="" class="btn btn-warning ">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <a href="" class="btn btn-danger">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>
</main>
@endsection
