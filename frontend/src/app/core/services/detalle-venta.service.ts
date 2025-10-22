import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface DetalleVenta {
  id?: number;
  venta_id: number;
  producto_id: number;
  cantidad: number;
  precio_unitario: number;
  subtotal?: number;
  venta?: any;
  producto?: any;
}

@Injectable({
  providedIn: 'root'
})
export class DetalleVentaService {

  private apiUrl = 'http://192.168.0.14:80/api/detalle_ventas'; // Cambia esto si tu API usa otro puerto o dominio

  constructor(private http: HttpClient) { }

  getAll(): Observable<{ success: boolean, data: DetalleVenta[] }> {
    return this.http.get<{ success: boolean, data: DetalleVenta[] }>(this.apiUrl);
  }

  getById(id: number): Observable<{ success: boolean, data: DetalleVenta }> {
    return this.http.get<{ success: boolean, data: DetalleVenta }>(`${this.apiUrl}/${id}`);
  }

  create(detalle: DetalleVenta): Observable<{ success: boolean, data: DetalleVenta }> {
    return this.http.post<{ success: boolean, data: DetalleVenta }>(this.apiUrl, detalle);
  }

  update(id: number, detalle: DetalleVenta): Observable<{ success: boolean, message: string }> {
    return this.http.put<{ success: boolean, message: string }>(`${this.apiUrl}/${id}`, detalle);
  }

  delete(id: number): Observable<{ success: boolean, message: string }> {
    return this.http.delete<{ success: boolean, message: string }>(`${this.apiUrl}/${id}`);
  }
}
