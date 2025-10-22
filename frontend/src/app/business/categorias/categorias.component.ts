import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CategoriaService, Categoria } from '../../core/services/categoria.service';
import Swal from 'sweetalert2';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-categorias',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './categorias.component.html',
  styleUrls: ['./categorias.component.css'],
})
export default class CategoriasComponent implements OnInit {
  categorias: Categoria[] = [];
  loading = true;
  mostrarModalCrearCategoria: boolean = false;
  nombre: string = ''; // Para el nombre de la nueva categoría
  descripcion: string = ''; // Para la descripción de la nueva categoría

  constructor(private categoriaService: CategoriaService) {}

  ngOnInit(): void {
    this.loadCategorias();
  }

  loadCategorias(): void {
    this.loading = true;
    this.categoriaService.getCategorias().subscribe({
      next: (data) => {
        this.categorias = data;
        this.loading = false;
      },
      error: (error) => {
        this.loading = false;
        Swal.fire('Error', error.message, 'error');
      },
    });
  }

  eliminarCategoria(id: number | undefined): void {
    if (!id) return;

    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Esta acción no se puede deshacer.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        this.categoriaService.deleteCategoria(id).subscribe({
          next: () => {
            this.categorias = this.categorias.filter((c) => c.id !== id);
            Swal.fire('¡Eliminado!', 'La categoría ha sido eliminada.', 'success');
          },
          error: (error) => {
            Swal.fire('Error', error.message, 'error');
          },
        });
      }
    });
  }

  abrirModalCrearCategoria(): void {
    this.mostrarModalCrearCategoria = true;
    this.nombre = '';
    this.descripcion = '';
  }

  cerrarModalCrearCategoria(): void {
    this.mostrarModalCrearCategoria = false;
  }

  guardarCategoria(): void {
    if (!this.nombre.trim()) {
      Swal.fire('Error', 'El nombre de la categoría es obligatorio.', 'error');
      return;
    }

    const nuevaCategoria: Categoria = {
      nombre: this.nombre,
      descripcion: this.descripcion,
    };

    this.categoriaService.createCategoria(nuevaCategoria).subscribe({
      next: (categoriaCreada) => {
        this.categorias.push(categoriaCreada);
        Swal.fire('Éxito', 'Categoría creada correctamente.', 'success');
        this.cerrarModalCrearCategoria();
      },
      error: (error) => {
        Swal.fire('Error', error.message, 'error');
      },
    });
  }
}
