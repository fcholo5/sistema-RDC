import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { environment } from '../../../environments/environment.development';

/**
 * Interfaz del proveedor
 */
export interface Supplier {
  id?: number;
  nombre: string;
  telefono?: string;
  email?: string;
  direccion?: string;
  created_at?: string;
  updated_at?: string;
}

@Injectable({
  providedIn: 'root',
})
export class SupplierService {
  private apiUrl = environment.serverUrl + 'proveedores';

  constructor(private http: HttpClient) {}

  /**
   * Manejo de errores HTTP
   */
  private handleError(error: HttpErrorResponse): Observable<never> {
    let errorMessage = 'Error inesperado al comunicarse con el servidor.';

    if (error.status === 0) {
      errorMessage = 'No se pudo conectar con el servidor.';
    } else if (typeof ProgressEvent !== 'undefined' && error.error instanceof ProgressEvent) {
      errorMessage = `Respuesta vacía o inválida.`;
    } else if (error.error && typeof error.error === 'object') {
      if ('message' in error.error && typeof error.error.message === 'string') {
        errorMessage = error.error.message;
      } else if ('errors' in error.error && typeof error.error.errors === 'object') {
        const validationErrors = Object.values(error.error.errors).flat().join(' ');
        errorMessage = `Errores de validación: ${validationErrors}`;
      } else {
        errorMessage = `Error del servidor: ${JSON.stringify(error.error)}`;
      }
    } else if (typeof error.error === 'string') {
      errorMessage = error.error;
    } else {
      errorMessage = error.message || 'Error desconocido.';
    }

    console.error('Error HTTP:', error);
    return throwError(() => new Error(errorMessage));
  }

  /**
   * Obtener todos los proveedores
   */
  getSuppliers(): Observable<Supplier[]> {
    return this.http.get<{ success: boolean; data: Supplier[] }>(this.apiUrl).pipe(
      map(res => res.data),
      catchError(this.handleError)
    );
  }

  /**
   * Obtener un proveedor por ID
   */
  getSupplier(id: number): Observable<Supplier> {
    return this.http.get<{ success: boolean; data: Supplier }>(`${this.apiUrl}/${id}`).pipe(
      map(res => res.data),
      catchError(this.handleError)
    );
  }

  /**
   * Crear nuevo proveedor
   */
  createSupplier(supplier: Supplier): Observable<Supplier> {
    return this.http.post<{ success: boolean; data: Supplier }>(this.apiUrl, supplier).pipe(
      map(res => res.data),
      catchError(this.handleError)
    );
  }

  /**
   * Actualizar proveedor existente
   */
  updateSupplier(supplier: Supplier): Observable<Supplier> {
    if (!supplier.id) {
      return throwError(() => new Error('Se requiere el ID del proveedor.'));
    }

    return this.http.put<{ success: boolean; data: Supplier }>(`${this.apiUrl}/${supplier.id}`, supplier).pipe(
      map(res => res.data),
      catchError(this.handleError)
    );
  }

  /**
   * Eliminar proveedor
   */
  deleteSupplier(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`).pipe(
      catchError(this.handleError)
    );
  }
}
