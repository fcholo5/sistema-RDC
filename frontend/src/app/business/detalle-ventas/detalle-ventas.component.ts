import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import Swal from 'sweetalert2'; // Mensajes de alerta

interface DetalleVenta {
  id?: number;
  venta_id: number;
  producto_id: number;
  cantidad: number;
  precio_unitario: number;
  subtotal?: number;
  producto?: any;
  venta?: any;
}

@Component({
  selector: 'app-detalle-ventas',
  standalone: true,
  imports: [CommonModule, HttpClientModule, FormsModule, RouterModule],
  templateUrl: './detalle-ventas.component.html',
  styleUrls: ['./detalle-ventas.component.css']
})
export class DetalleVentasComponent implements OnInit {
  detalles: DetalleVenta[] = [];
  nuevoDetalle: DetalleVenta = {
    venta_id: 0,
    producto_id: 0,
    cantidad: 0,
    precio_unitario: 0
  };
  loading: boolean = true;
  apiUrl = 'http://192.168.0.14:80/api/detalle_ventas';

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.cargarDetalles();
  }

  /**
   * Carga todos los detalles de venta desde la API.
   */
  cargarDetalles(): void {
    this.loading = true;
    this.http.get<any>(this.apiUrl).subscribe({
      next: res => {
        this.detalles = res.data;
        this.loading = false;
      },
      error: err => {
        this.loading = false;
        console.error('Error cargando detalles:', err);
        Swal.fire({
          icon: 'error',
          title: 'Error de carga',
          text: err.message || 'No se pudieron cargar los detalles.',
          confirmButtonText: 'Aceptar'
        });
      }
    });
  }

  /**
   * Crea un nuevo detalle de venta.
   */
  crearDetalle(): void {
    this.http.post<any>(this.apiUrl, this.nuevoDetalle).subscribe({
      next: res => {
        this.detalles.push(res.data);
        this.nuevoDetalle = {
          venta_id: 0,
          producto_id: 0,
          cantidad: 0,
          precio_unitario: 0
        };
        Swal.fire({
          icon: 'success',
          title: 'Detalle creado',
          text: 'El detalle de venta fue agregado correctamente.'
        });
      },
      error: err => {
        console.error('Error creando detalle:', err);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: err.message || 'No se pudo crear el detalle.',
          confirmButtonText: 'Aceptar'
        });
      }
    });
  }

  /**
   * Actualiza un detalle existente.
   */
  actualizarDetalle(detalle: DetalleVenta): void {
    const url = `${this.apiUrl}/${detalle.id}`;
    this.http.put<any>(url, detalle).subscribe({
      next: () => {
        Swal.fire({
          icon: 'success',
          title: 'Actualizado',
          text: 'Detalle actualizado correctamente.'
        });
      },
      error: err => {
        console.error('Error actualizando detalle:', err);
        Swal.fire({
          icon: 'error',
          title: 'Error al actualizar',
          text: err.message || 'No se pudo actualizar el detalle.'
        });
      }
    });
  }

  /**
   * Elimina un detalle de venta con confirmación.
   */
  eliminarDetalle(id: number): void {
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Este detalle será eliminado permanentemente.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then(result => {
      if (result.isConfirmed) {
        const url = `${this.apiUrl}/${id}`;
        this.http.delete<any>(url).subscribe({
          next: () => {
            this.detalles = this.detalles.filter(d => d.id !== id);
            Swal.fire('Eliminado', 'El detalle fue eliminado.', 'success');
          },
          error: err => {
            console.error('Error eliminando detalle:', err);
            Swal.fire({
              icon: 'error',
              title: 'Error al eliminar',
              text: err.message || 'No se pudo eliminar el detalle.'
            });
          }
        });
      }
    });
  }
}
