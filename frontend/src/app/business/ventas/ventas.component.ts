import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
// Ajusta la ruta según la ubicación real de venta.service.ts
import { VentaService } from '../../core/services/venta.service';
import { FormsModule } from '@angular/forms';
import { Product, ProductService, ProductToSell } from '../../core/services/product.service';
import Swal from 'sweetalert2';

export interface VentaRequest {
  cliente_id?: number;
  metodo_de_pago: string;
  productos: ProductToSell[];
}

interface Linea {
  id?: number;
  nombre: string;
  cantidad: number;
  precio: number;
}

interface Producto {
  id?: number;
  nombre: string;
  cantidad: number;
  precio: number;
}

@Component({
  selector: 'app-ventas',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './ventas.component.html',
  styleUrl: './ventas.component.css'
})
export class VentasComponent implements OnInit {
  ventas: any[] = [];
  mostrarModalVenta: boolean = false;
  clienteId: number | null = null;
  // products: ProductToSell[] = [];
  allProducts: Product[] = []; // Todos los productos disponibles
  productos: Linea[] = [{ nombre: '', cantidad: 1, precio: 0 }];
  filteredProducts: Product[][] = []; // un array de sugerencias por cada línea

  // Datos simulados para registrar una venta (en producción usaría un formulario)
  // nuevaVenta = {
  //   cliente_id: undefined,
  //   metodo_de_pago: 'Efectivo',
  //   productos_id: [1, 2],
  //   cantidades: [1, 2],
  //   precios: [5000, 7000]
  // };
alerta: any;

  constructor(private ventaService: VentaService, private productService: ProductService) {}

  ngOnInit(): void {
    this.cargarVentas();
    this.getProducts(); // Carga los productos al iniciar el componente
  }

  cargarVentas(): void {
    this.ventaService.getVentas().subscribe({
      next: (res) => {
        this.ventas = res.data;
      },
      error: (err) => {
        console.error('Error al cargar ventas:', err);
      }
    });
  }

  getProducts(): void {
      this.productService.getProducts().subscribe({
        next: (data) => {
          this.allProducts = data;
          console.log('Productos cargados:', this.allProducts);
          this.resetFilters(); // Inicializa los filtros
        },
        error: (error) => {
          console.error('Error al cargar los productos:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error de carga',
            text: error.message || 'No se pudieron cargar los productos. Inténtalo de nuevo.',
            confirmButtonText: 'Aceptar'
          });
        }
      });
    }

    resetFilters() {
      this.filteredProducts = this.productos.map(_ => [...this.allProducts]);
    }

  // registrarVenta(): void {
  //   this.ventaService.crearVenta(this.nuevaVenta).subscribe({
  //     next: (res) => {
  //       alert('Venta registrada correctamente.');
  //       this.cargarVentas();
  //     },
  //     error: (err) => {
  //       console.error('Error al registrar venta:', err);
  //     }
  //   });
  // }

  // eliminarVenta(id: number): void {
  //   if (!confirm('¿Estás seguro de que deseas eliminar esta venta?')) return;

  //   this.ventaService.eliminarVenta(id).subscribe({
  //     next: () => {
  //       alert('Venta eliminada.');
  //       this.cargarVentas();
  //     },
  //     error: (err) => {
  //       console.error('Error al eliminar venta:', err);
  //     }
  //   });
  // }

  abrirModalVenta(): void {
    this.mostrarModalVenta = true; // Muestra el modal
  }

  cerrarModalVenta(): void {
    this.mostrarModalVenta = false; // Cierra el modal
    this.clienteId = null;
    this.productos = [{ nombre: '', cantidad: 1, precio: 0 }];
    this.resetFilters();
  }

  agregarProducto() {
    this.productos.push({ nombre: '', cantidad: 1, precio: 0 });
    this.filteredProducts.push([...this.allProducts]);
  }

  eliminarProducto(i: number) {
    this.productos.splice(i, 1);
    this.filteredProducts.splice(i, 1);
  }

  onNombreChange(value: string, i: number) {
    const filtro = value.toLowerCase();
    this.filteredProducts[i] = this.allProducts.filter(p =>
      p.nombre.toLowerCase().includes(filtro)
    );
  }

  selectProduct(prod: Product, i: number) {
    this.productos[i].nombre = prod.nombre;
    this.productos[i].precio = prod.precio_venta;
    this.productos[i].id = prod.id;
    // cerramos sugerencias
    this.filteredProducts[i] = [];
  }

  confirmarVenta() {
    const ventaRequest: VentaRequest = {
      cliente_id: this.clienteId!,
      metodo_de_pago: 'Efectivo',
      productos: this.productos.map(p => ({
        id: p.id!,
        nombre: p.nombre!,
        cantidad: p.cantidad!,
        precio: p.precio!
      }))
    };
    console.log('Payload venta:', ventaRequest);
    this.ventaService.crearVenta(ventaRequest).subscribe({
      next: (res) => {
        Swal.fire('Éxito', 'Venta registrada correctamente.', 'success');
        this.cargarVentas(); // Recarga la lista de ventas
        this.cerrarModalVenta(); // Cierra el modal
      },
      error: (err) => {
        console.error('Error al registrar venta:', err);
        Swal.fire({
          icon: 'error',
          title: 'Error al registrar venta',
          text: err.message || 'No se pudo registrar la venta. Inténtalo de nuevo.',
          confirmButtonText: 'Aceptar'
        });
      }
    });
    this.cerrarModalVenta();
  }
}
