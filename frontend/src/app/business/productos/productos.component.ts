import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common'; // Para *ngFor, *ngIf, CurrencyPipe
import { RouterLink } from '@angular/router'; // Para routerLink en el HTML
import Swal from 'sweetalert2'; // Para mensajes de alerta
// Importa el servicio y la interfaz de producto (que incluye Categoría y Proveedor)
import { ProductService, Product } from '../../core/services/product.service'; // <-- CORREGIDO AQUÍ
import { FormsModule } from '@angular/forms';
import { Categoria, CategoriaService } from '../../core/services/categoria.service';
import { Supplier, SupplierService } from '../../core/services/supplier.service';


@Component({
  selector: 'app-productos',
  standalone: true,
  imports: [
    CommonModule,
    RouterLink, // No olvides importar RouterLink
    FormsModule // Importa FormsModule para usar [(ngModel)]
  ],
  templateUrl: './productos.component.html',
  styleUrl: './productos.component.css'
})
export default class ProductosComponent implements OnInit {
[x: string]: any;

  products: Product[] = []; // Array para almacenar los productos
  loading: boolean = true; // Para mostrar un estado de carga
  alerta: any;
  mostrarModalTipoProducto: boolean = false;
  nombre: string = ''; // Para el nombre del nuevo producto
  descripcion: string = ''; // Para la descripción del nuevo producto
  cantidad: number | null = null; // Para la cantidad del nuevo producto
  precioCompra: number | null = null; // Para el precio de compra del nuevo producto
  precioVenta: number | null = null; // Para el precio de venta del nuevo producto
  categoriaId: number | null = null; // Para el ID de la categoría del nuevo producto
  proveedorId: number | null = null; // Para el ID del proveedor del nuevo producto
  categorias: Categoria[] = [];
  loadingCategory = true;
  proveedores: Supplier[] = [];
  proveedoresSeleccionada: number | null = null;
  loadingProveedores = true;
  


  constructor(private productService: ProductService, private categoriaService: CategoriaService , private supplierService: SupplierService) {
    // Inicializa el componente con los servicios necesarios
    this.products = []; // Asegúrate de inicializar el array de productos
    this.categorias = []; // Inicializa el array de categorías
    this.proveedores = []; // Inicializa el array de proveedores


  }

  ngOnInit(): void {
    this.getProducts(); // Carga los productos al iniciar el componente
    this.loadCategorias(); // Carga las categorías al iniciar el componente
    this.loadProveedores(); // Carga los proveedores al iniciar el componente
    this.categoriaId = 0; // Inicializa la categoría seleccionada
    this.proveedorId = 0; // Inicializa el proveedor seleccionado
  }

  /**
   * Obtiene la lista de productos desde el ProductService.
   */
  getProducts(): void {
    this.loading = true; // Activa el estado de carga
    this.productService.getProducts().subscribe({
      next: (data) => {
        this.products = data;
        this.loading = false; // Desactiva el estado de carga
        console.log('Productos cargados:', this.products);
      },
      error: (error) => {
        this.loading = false; // Desactiva el estado de carga incluso si hay error
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

  loadCategorias(): void {
    this.loading = true;
    this.categoriaService.getCategorias().subscribe({
      next: (data) => {
        this.categorias = data;
        this.loadingCategory = false;
        console.log('Categorías cargadas:', this.categorias);
      },
      error: (error) => {
        this.loadingCategory = false;
        Swal.fire('Error', error.message, 'error');
      },
    });
  }

  loadProveedores(): void {
    this.loading = true;
    this.supplierService.getSuppliers().subscribe({
      next: (data) => {
        this.proveedores = data;
        this.loadingProveedores = false;
      },
      error: (error) => {
        this.loadingProveedores = false;
        Swal.fire('Error', error.message, 'error');
      },
    });
  }
  /**
   * Elimina un producto por su ID.
   * @param productId El ID del producto a eliminar.
   */
  deleteProduct(productId: number | undefined): void {
    if (productId === undefined) {
      console.error('Error: ID de producto no definido para eliminar.');
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
        this.productService.deleteProduct(productId).subscribe({
          next: () => {
            // Elimina el producto del array localmente para actualizar la vista
            this.products = this.products.filter(p => p.id !== productId);
            Swal.fire(
              '¡Eliminado!',
              'El producto ha sido eliminado.',
              'success'
            );
          },
          error: (error) => {
            console.error('Error al eliminar el producto:', error);
            Swal.fire({
              icon: 'error',
              title: 'Error al eliminar',
              text: error.message || 'No se pudo eliminar el producto. Inténtalo de nuevo.',
              confirmButtonText: 'Aceptar'
            });
          }
        });
      }
    });
  }

  nuevoProductoModal(): void {
    this.mostrarModalTipoProducto = true; // Muestra el modal para crear un nuevo producto
  }

  cerrarModalNuevoProducto(): void {
    this.mostrarModalTipoProducto = false; // Cierra el modal
  }

  guardarProducto(): void {
    if (!this.nombre || !this.descripcion || this.cantidad === null || this.precioCompra === null || this.precioVenta === null || this.categoriaId === 0 || this.proveedorId === 0) {
      Swal.fire('Error', 'Por favor, completa todos los campos.', 'error');
      return;
    }

    const nuevoProducto: Product = {
      nombre: this.nombre,
      descripcion: this.descripcion,
      cantidad: this.cantidad,
      precio_compra: this.precioCompra,
      precio_venta: this.precioVenta,
      categoria_id: this.categoriaId!,
      proveedor_id: this.proveedorId!,
      precio: undefined
    };

    this.productService.createProduct(nuevoProducto).subscribe({
      next: (data) => {
        Swal.fire('Éxito', 'Producto creado correctamente.', 'success');
        this.getProducts(); // Recarga la lista de productos
        this.cerrarModalNuevoProducto(); // Cierra el modal
        // Limpia los campos del formulario
        this.nombre = '';
        this.descripcion = '';
        this.cantidad = null;
        this.precioCompra = null;
        this.precioVenta = null;
        this.categoriaId = null;
        this.proveedorId = null;
        console.log('Producto creado:', data);
      },
      error: (error) => {
        console.error('Error al crear el producto:', error);
        Swal.fire('Error', error.message || 'No se pudo crear el producto. Inténtalo de nuevo.', 'error');
      }
    });
  }
}