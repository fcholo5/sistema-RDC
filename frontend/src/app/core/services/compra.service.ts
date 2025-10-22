// src/app/core/services/compra.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Compra {
  id?: number;
  producto_id: number;
  cantidad: number;
  precio_unitario: number;
  sub_total?: number;
  producto?: any;
}

@Injectable({
  providedIn: 'root'
})
export class CompraService {
  private apiUrl = 'http://192.168.0.14/api/compras';

  constructor(private http: HttpClient) {}

  getAll(): Observable<{ success: boolean; data: Compra[] }> {
    return this.http.get<{ success: boolean; data: Compra[] }>(this.apiUrl);
  }

  getById(id: number): Observable<{ success: boolean; data: Compra }> {
    return this.http.get<{ success: boolean; data: Compra }>(`${this.apiUrl}/${id}`);
  }

  create(compra: Compra): Observable<{ success: boolean; data: Compra; message: string }> {
    return this.http.post<{ success: boolean; data: Compra; message: string }>(this.apiUrl, compra);
  }

  update(id: number, compra: Partial<Compra>): Observable<{ success: boolean; data: Compra; message: string }> {
    return this.http.put<{ success: boolean; data: Compra; message: string }>(`${this.apiUrl}/${id}`, compra);
  }

  delete(id: number): Observable<{ success: boolean; message: string }> {
    return this.http.delete<{ success: boolean; message: string }>(`${this.apiUrl}/${id}`);
  }
}
