@extends('layouts.main')

@session('titulo', $titulo)

@endsession('contenido')


<main id="main" class="main">

    <div class="pagetitle">
      <h1> Editar usuario</h1>
      <nav>
        
      </nav>
    </div><!-- End Page Title -->
     <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Editar usuario</h5>
            <form action="{{ route('usuarios.update',$item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="name">Nombre de usuario</label>
                <input type="text" class="form-control" required name="name" id="name" value="{{ $item->name }}">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" required value="{{ $item->name }}">
                <label for="rol">Rol de usuario</label>
                <select name="rol" id="rol" class="form-select">
                    <option value="">selecciona el rol</option>
                    @if ($item->rol =='admin')
                        <option value="admin" selected>Admin</option>
                        <option value="vendedor">Vendedor</option>
                    @else
                      <option value="admin">Admin</option>
                      <option value="vendedor" selected>Vendedor</option>
                    @endif

                    

                </select>
                <button class="btn btn-primary mt-3">Atualizar</button>
                <a href="{{ route('usuarios') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>
            </div>
          </div>

        </div>
      </div>
    </section>

    

  </main><!-- End #main -->


