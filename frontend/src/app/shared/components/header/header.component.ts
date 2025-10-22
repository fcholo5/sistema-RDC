import { Component, EventEmitter, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink, RouterLinkActive, Router } from '@angular/router'; // Import Router

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [
    CommonModule
],
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css'] // Si tienes CSS extra que no sea Tailwind directamente
})
export class HeaderComponent {
  @Output() toggleSidebarEvent = new EventEmitter<void>();

  constructor(private router: Router) {} // Inyecta Router

  toggleSidebar() {
    // Asumiendo que el toggle del sidebar en esta plantilla Tailwind
    // también añade/quita una clase al body o a un contenedor principal
    document.body.classList.toggle('sidebar-toggled'); // O la clase que use tu plantilla Tailwind
    this.toggleSidebarEvent.emit();
  }

  logout() {
    console.log('Logging out...');
    // Implementar lógica de logout con tu servicio de autenticación
    this.router.navigate(['/login']); // Navegar al login después de cerrar sesión
  }
}