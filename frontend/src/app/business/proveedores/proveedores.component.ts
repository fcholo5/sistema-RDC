// src/app/dashboard/proveedores/proveedores.component.ts
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import Swal from 'sweetalert2';
import { SupplierService, Supplier } from '../../core/services/supplier.service';

@Component({
  selector: 'app-proveedores',
  standalone: true,
  imports: [
    CommonModule,
    RouterLink
  ],
  templateUrl: './proveedores.component.html',
  styleUrls: ['./proveedores.component.css']
})
export default class ProveedoresComponent implements OnInit {
  suppliers: Supplier[] = [];
  loading: boolean = true;

  constructor(private supplierService: SupplierService) {}

  ngOnInit(): void {
    this.getSuppliers();
  }

  getSuppliers(): void {
    this.loading = true;
    this.supplierService.getSuppliers().subscribe({
      next: (data) => {
        this.suppliers = data;
        this.loading = false;
        console.log('Proveedores cargados:', this.suppliers);
      },
      error: (error) => {
        this.loading = false;
        console.error('Error al cargar proveedores:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error al cargar',
          text: error.message || 'No se pudieron cargar los proveedores.',
          confirmButtonText: 'Aceptar'
        });
      }
    });
  }

  deleteSupplier(supplierId: number | undefined): void {
    if (!supplierId) {
      Swal.fire('Error', 'ID de proveedor no definido', 'error');
      return;
    }

    Swal.fire({
      title: '¿Estás seguro?',
      text: '¡Esta acción no se puede revertir!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.supplierService.deleteSupplier(supplierId).subscribe({
          next: () => {
            this.suppliers = this.suppliers.filter(s => s.id !== supplierId);
            Swal.fire('¡Eliminado!', 'Proveedor eliminado correctamente.', 'success');
          },
          error: (error) => {
            console.error('Error al eliminar proveedor:', error);
            Swal.fire('Error', error.message || 'No se pudo eliminar el proveedor.', 'error');
          }
        });
      }
    });
  }
}
