// src/app/pages/compras/compras.component.ts
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { CompraService, Compra } from '../../core/services/compra.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-compras',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './compras.component.html',
  styleUrls: ['./compras.component.css']
})
export default class ComprasComponent implements OnInit {
producto: any;
cancelar() {
throw new Error('Method not implemented.');
}
  compras: Compra[] = [];
  nuevaCompra: Compra = {
    producto_id: 0,
    cantidad: 0,
    precio_unitario: 0
  };
  loading = true;

  constructor(private compraService: CompraService) {}

  ngOnInit(): void {
    this.obtenerCompras();
  }

  obtenerCompras(): void {
    this.loading = true;
    this.compraService.getAll().subscribe({
      next: (res) => {
        this.compras = res.data;
        this.loading = false;
      },
      error: (err) => {
        console.error('Error al obtener compras:', err);
        this.loading = false;
      }
    });
  }

  crearCompra(): void {
    this.compraService.create(this.nuevaCompra).subscribe({
      next: (res) => {
        this.compras.push(res.data);
        this.nuevaCompra = { producto_id: 0, cantidad: 0, precio_unitario: 0 };
        Swal.fire('Éxito', res.message, 'success');
      },
      error: (err) => {
        console.error('Error al crear compra:', err);
        Swal.fire('Error', err.error?.message || 'Error al crear la compra', 'error');
      }
    });
  }

  eliminarCompra(id: number): void {
    Swal.fire({
      title: '¿Eliminar compra?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.compraService.delete(id).subscribe({
          next: (res) => {
            this.compras = this.compras.filter(c => c.id !== id);
            Swal.fire('Eliminado', res.message, 'success');
          },
          error: (err) => {
            Swal.fire('Error', err.error?.message || 'Error al eliminar la compra', 'error');
          }
        });
      }
    });
  }
}
