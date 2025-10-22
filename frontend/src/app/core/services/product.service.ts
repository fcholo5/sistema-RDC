import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { environment } from '../../../environments/environment.development';

// Interfaz para Producto
export interface Product {
  precio: any;
  id?: number;
  nombre: string;
  descripcion?: string;
  cantidad: number;
  precio_compra: number;
  precio_venta: number;
  categoria_id: number;
  proveedor_id: number;
  categoria?: {
    id: number;
    nombre: string;
  };
  proveedor?: {
    id: number;
    nombre: string;
  };
}

// Producto a vender
export interface ProductToSell {
  id: number;
  nombre: string;
  cantidad: number;
  precio: number;
}

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private apiUrl = environment.serverUrl + 'productos';

  constructor(private http: HttpClient) {}

  /**
   * Manejo de errores HTTP
   */
  private handleError(error: HttpErrorResponse): Observable<never> {
    let message = 'Error inesperado.';
    if (error.status === 0) {
      message = 'No se pudo conectar con el servidor.';
    } else if (error.error?.message) {
      message = error.error.message;
    } else if (error.error?.errors) {
      message = Object.values(error.error.errors).flat().join(' ');
    } else {
      message = error.message;
    }

    console.error('Error procesado:', error);
    return throwError(() => new Error(message));
  }

  // Obtener todos los productos
  getProducts(): Observable<Product[]> {
    return this.http.get<{ success: boolean; data: Product[] }>(this.apiUrl).pipe(
      map(res => res.data),
      catchError(this.handleError)
    );
  }

  // Obtener producto por ID
  getProduct(id: number): Observable<Product> {
    return this.http.get<{ success: boolean; data: Product }>(`${this.apiUrl}/${id}`).pipe(
      map(res => res.data),
      catchError(this.handleError)
    );
  }

  // Crear producto
  createProduct(product: Product): Observable<Product> {
    return this.http.post<{ success: boolean; data: Product }>(this.apiUrl, product).pipe(
      map(res => res.data),
      catchError(this.handleError)
    );
  }

  // Actualizar producto
  updateProduct(product: Product): Observable<Product> {
    if (!product.id) {
      return throwError(() => new Error('ID del producto requerido.'));
    }

    return this.http.put<{ success: boolean; data: Product }>(`${this.apiUrl}/${product.id}`, product).pipe(
      map(res => res.data),
      catchError(this.handleError)
    );
  }

  // Eliminar producto
  deleteProduct(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`).pipe(
      catchError(this.handleError)
    );
  }
}
