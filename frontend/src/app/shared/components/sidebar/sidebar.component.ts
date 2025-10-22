import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink, RouterLinkActive } from '@angular/router';

@Component({
  selector: 'app-sidebar', // Este selector es el que usarás en layout.component.html
  standalone: true,
  imports: [
    CommonModule,
    RouterLink,
    RouterLinkActive
  ],
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css'] // Aquí irá el CSS específico de tu sidebar
})
export class SidebarComponent {
  isOpen: boolean = false;
  ventasAbierto: boolean = false;

  sidebarItems = [
    { link: '/dashboard/categorias', label: 'Categorías', icon: 'bi bi-card-list' },
    { link: '/dashboard/productos', label: 'Productos', icon: 'bi bi-box-arrow-in-right' },
    { link: '/dashboard/clientes', label: 'Clientes', icon: 'bi bi-people' },
    { link: '/dashboard/proveedores', label: 'Proveedores', icon: 'bi bi-truck' },
    { link: '/dashboard/usuarios', label: 'Usuarios', icon: 'bi bi-person-circle' }
  ];

  toggleSidebar() {
    this.isOpen = !this.isOpen;
  }

  toggleVentas() {
    this.ventasAbierto = !this.ventasAbierto;
  }
}
