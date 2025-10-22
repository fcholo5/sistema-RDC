import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment.development';
import { VentaRequest } from '../../business/ventas/ventas.component';

interface Venta {
  id?: number;
  cliente_id?: number;
  user_id?: number;
  fecha?: string;
  total_venta?: number;
  metodo_de_pago: string;
  detalles?: DetalleVenta[];
}

interface DetalleVenta {
  productos_id: number;
  cantidad: number;
  precio_unitario: number;
  sub_total: number;
}

@Injectable({
  providedIn: 'root'
})
export class VentaService {
  private apiUrl = `${environment.serverUrl}ventas`;

  constructor(private http: HttpClient) { }

  // Obtener todas las ventas con cliente y usuario
  getVentas(): Observable<any> {
    return this.http.get<any>(this.apiUrl);
  }

  // Registrar una nueva venta
  crearVenta(ventaData: VentaRequest): Observable<any> {
    return this.http.post<any>(this.apiUrl, ventaData);
  }

  // Eliminar una venta y restaurar el stock
  eliminarVenta(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}/${id}`);
  }
}
