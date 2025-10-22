@extends('layouts.main')

@session('titulo', $titulo)

@endsession('contenido')


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Usuarios</h1>
      <nav>
        
      </nav>
    </div><!-- End Page Title -->
     <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Administrar Usuarios</h5>
              <p>
                Adminstrar la cuentas y roles de usuarios
              </p>
              <!-- Table with stripped rows -->

               <a href="{{ route('usuarios.create') }}" class="btn btn-primary"> 
                <i class="fa-solid fa-user-plus"></i>Agregar un nuevo Usuario
              </a>
              <hr>
              <table class="table datables">

                <thead>
                  <tr>
                    <th class="text-center"> Email </th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Rol</th>
                    <th class="text-center">Cambio Password</th>
                    <th class="text-center">Estado</th>
                   
                    <th class="text-center">
                      Edictar
                    </th>
                  </tr>
                </thead>
                <tbody id="tbody-usuarios">
                  @include('modules.usuarios.tbody')
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>
   
</main> <!-- End #main -->
    
    @push('scripts')
      <script>
        function recargar_tbody(){
          $.ajax({
            type : "GET",
            url : "{{ route('usuarios.tbody') }}",
            success : function(respuesta){
              console.log(respuesta);
            }
          })
        }

        function cambiar_estado(id, estado){
          $.ajax({
            type: "GET",
            url : "usuarios/cambiar-estado/" + id + "/" + estado,
            success:function(respuesta){
              if (respuesta ==1){
                swal.fire({
                  title:'fallo!',
                  texto: 'no se pudo realizar el cambio!',
                  icon: 'error',
                  confirmButtonTex:'Aceptar'
                })
                recargar_tbody()
              }
            }
          })
        }

      $(document).ready(function(){ 
        $('.form-check-input').on("change", function(){
          let id = $(this).attr("id");
          let estado = $(this).is(":checked") ? 1 : 0;
          cambiar_estado(id,estado);
        })
      });
      </script>
    @endpush




