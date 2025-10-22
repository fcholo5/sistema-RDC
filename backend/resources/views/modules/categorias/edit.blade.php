@extends('layouts.main')

@session('titulo', $titulo)

@endsession('contenido')


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Editar Categoria</h1>
      <nav>
        
      </nav>
    </div><!-- End Page Title -->
     <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Editar categoria</h5>
            <form action="{{ route('categorias.update',$item->id) }}" method="POST">
                @csrf
                @method ("PUT")
                <label for="nombre">Nombre de la categoria</label>
                <input type="text" class="form-control"
                 required name="nombre" id="nombre" value="{{ $item->nombre }}">
                <button class="btn btn-warning mt-3">Atualizar</button>
                <a href="{{ route('categorias') }}" class="btn btn-info mt-3">
                    Cancelar

                </a>
            </form>
            </div>
          </div>

        </div>
      </div>
    </section>

    

  </main><!-- End #main -->


