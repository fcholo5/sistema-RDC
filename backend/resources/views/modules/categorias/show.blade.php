@extends('layouts.main')

@session('titulo', $titulo)

@endsession('contenido')


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Eliminar categoria</h1>
      <nav>
        
      </nav>
    </div><!-- End Page Title -->
     <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Estas seguro de eliminar esta categoria</h5>
            <form action="{{ route('categorias.destroy',$item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <label for="nombre">Nombre de la categoria</label>
                <input type="text" class="form-control" readonly
                 name="nombre" id="nombre" value="{{ $item->nombre }}">
                <button class="btn btn-primary mt-3">Eliminar</button>
                <a href="{{ route('categorias') }}" class="btn btn-info mt-3">
                Cancelar</a>
            </form>
            </div>
          </div>

        </div>
      </div>
    </section>

    

  </main><!-- End #main -->


