// src/app/core/services/categoria.service.ts
import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { environment } from '../../../environments/environment.development';

export interface Categoria {
  id?: number;
  nombre: string;
  descripcion: string;
  created_at?: string;
  updated_at?: string;
}

@Injectable({ providedIn: 'root' })
export class CategoriaService {
  private apiUrl = `${environment.serverUrl}categorias`;

  constructor(private http: HttpClient) {}

  private handleError(error: HttpErrorResponse): Observable<never> {
    let message = 'Error desconocido';
    if (error.error instanceof ProgressEvent) {
      message = 'No hay conexión con el servidor.';
    } else if (error.error?.message) {
      message = error.error.message;
    }
    return throwError(() => new Error(message));
  }

  getCategorias(): Observable<Categoria[]> {
    return this.http.get<{ success: boolean; data: Categoria[] }>(this.apiUrl).pipe(
      map((res) => res.data),
      catchError(this.handleError)
    );
  }

  getCategoria(id: number): Observable<Categoria> {
    return this.http.get<{ success: boolean; data: Categoria }>(`${this.apiUrl}/${id}`).pipe(
      map((res) => res.data),
      catchError(this.handleError)
    );
  }

  createCategoria(categoria: Categoria): Observable<Categoria> {
    return this.http.post<{ success: boolean; data: Categoria }>(this.apiUrl, categoria).pipe(
      map((res) => res.data),
      catchError(this.handleError)
    );
  }

  updateCategoria(id: number, categoria: Categoria): Observable<Categoria> {
    return this.http.put<{ success: boolean; data: Categoria }>(`${this.apiUrl}/${id}`, categoria).pipe(
      map((res) => res.data),
      catchError(this.handleError)
    );
  }

  deleteCategoria(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`).pipe(
      catchError(this.handleError)
    );
  }
}
