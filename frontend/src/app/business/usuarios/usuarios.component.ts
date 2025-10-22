import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common'; // Necesario para ngIf, ngFor
import { FormsModule } from '@angular/forms'; // Necesario si usas ngModel en el HTML (ej. para búsqueda o formularios)
import Swal from 'sweetalert2'; // Importa SweetAlert2

// Importa el UserService y la interfaz User
import { UserService, User } from '../../core/services/user.service';

@Component({
  selector: 'app-usuarios',
  standalone: true,
  imports: [
    CommonModule,
    FormsModule // Si planeas usar formularios o ngModel en este componente
  ],
  templateUrl: './usuarios.component.html',
  styleUrls: ['./usuarios.component.css'] // Corregido a 'styleUrls' para array
})
export default class UsuariosComponent implements OnInit {
openChangePasswordModal(arg0: number|undefined) {
throw new Error('Method not implemented.');
}
  users: User[] = []; // Array para almacenar la lista de usuarios
  loading: boolean = true; // Para mostrar un spinner o mensaje de carga

  // Inyecta el UserService en el constructor
  constructor(private userService: UserService) { }

  // ngOnInit se ejecuta cuando el componente se inicializa
  ngOnInit(): void {
    this.getUsers(); // Llama al método para cargar los usuarios al inicio
  }

  /**
   * Obtiene la lista de usuarios desde el UserService.
   */
  getUsers(): void {
    this.loading = true; // Activa el estado de carga
    this.userService.getUsers().subscribe({
      next: (data) => {
        this.users = data; // Asigna los datos recibidos a la propiedad users
        this.loading = false; // Desactiva el estado de carga
        console.log('Usuarios cargados:', this.users); // Para depuración
      },
      error: (error) => {
        this.loading = false; // Desactiva el estado de carga incluso si hay error
        console.error('Error al cargar los usuarios:', error);
        // Muestra un mensaje de error al usuario usando SweetAlert2
        Swal.fire({
          icon: 'error',
          title: 'Error al cargar usuarios',
          text: error.message || 'No se pudieron cargar los usuarios. Inténtalo de nuevo.',
          confirmButtonText: 'Aceptar'
        });
      }
    });
  }

  /**
   * Cambia el estado de un usuario (activo/inactivo).
   * @param userId El ID del usuario a modificar.
   * @param newStatus El nuevo estado (1 para activo, 0 para inactivo).
   */
  cambiarEstado(userId: number | undefined, newStatus: number): void {
    if (userId === undefined) {
      console.error('Error: ID de usuario no definido para cambiar estado.');
      Swal.fire({
        icon: 'error',
        title: 'Error de usuario',
        text: 'No se pudo identificar al usuario para cambiar su estado.',
        confirmButtonText: 'Aceptar'
      });
      return;
    }

    // Opcional: Mostrar una confirmación antes de cambiar el estado
    Swal.fire({
      title: '¿Estás seguro?',
      text: `¿Deseas ${newStatus === 1 ? 'activar' : 'desactivar'} este usuario?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, cambiar estado',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Llama al método de actualización del UserService
        this.userService.updateUserStatus(userId, newStatus).subscribe({
          next: (updatedUser) => {
            // Encuentra el usuario en el array y actualiza su estado localmente
            const index = this.users.findIndex(u => u.id === updatedUser.id);
            if (index !== -1) {
              this.users[index].status = updatedUser.status; // Actualiza solo el estado
              // Si tu backend devuelve el objeto User completo, podrías hacer:
              // this.users[index] = updatedUser;
            }
            Swal.fire(
              '¡Actualizado!',
              `El usuario ha sido ${newStatus === 1 ? 'activado' : 'desactivado'} con éxito.`,
              'success'
            );
          },
          error: (error) => {
            console.error('Error al cambiar el estado del usuario:', error);
            Swal.fire({
              icon: 'error',
              title: 'Error al actualizar',
              text: error.message || 'No se pudo cambiar el estado del usuario. Inténtalo de nuevo.',
              confirmButtonText: 'Aceptar'
            });
          }
        });
      }
    });
  }

  // --- Métodos de ejemplo para otras operaciones (CREAR, EDITAR, ELIMINAR) ---

  // Método para eliminar un usuario (ejemplo)
  deleteUser(userId: number | undefined): void {
    if (userId === undefined) {
      console.error('Error: ID de usuario no definido para eliminar.');
      return;
    }

    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡No podrás revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, ¡eliminar!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.userService.deleteUser(userId).subscribe({
          next: () => {
            // Elimina el usuario del array localmente
            this.users = this.users.filter(user => user.id !== userId);
            Swal.fire(
              '¡Eliminado!',
              'El usuario ha sido eliminado.',
              'success'
            );
          },
          error: (error) => {
            console.error('Error al eliminar el usuario:', error);
            Swal.fire({
              icon: 'error',
              title: 'Error al eliminar',
              text: error.message || 'No se pudo eliminar el usuario. Inténtalo de nuevo.',
              confirmButtonText: 'Aceptar'
            });
          }
        });
      }
    });
  }
  usuarioModalVisible: boolean = false;
esEdicion: boolean = false;
usuarioEnEdicion: User = {
  name: '',
  email: '',
  password: '',
  rol_id: 2,
  status: 1
};

abrirModalUsuario(usuario?: User): void {
  this.esEdicion = !!usuario;
  this.usuarioEnEdicion = usuario ? { ...usuario } : {
    name: '',
    email: '',
    password: '',
    rol_id: 2,
    status: 1
  };
  this.usuarioModalVisible = true;
}

cerrarModalUsuario(): void {
  this.usuarioModalVisible = false;
}
guardarUsuario(): void {
  const operacion = this.esEdicion
    ? this.userService.updateUser(this.usuarioEnEdicion)
    : this.userService.createUser(this.usuarioEnEdicion);

  operacion.subscribe({
    next: (user) => {
      Swal.fire('Éxito', `Usuario ${this.esEdicion ? 'actualizado' : 'creado'} correctamente.`, 'success');
      this.getUsers();
      this.cerrarModalUsuario();
    },
    error: (err) => {
      Swal.fire('Error', err.message || 'No se pudo guardar el usuario.', 'error');
    }
  });
}


}