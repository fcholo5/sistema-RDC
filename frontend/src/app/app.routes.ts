import { Routes } from '@angular/router';
import { AuthGuard } from './core/guards/auth.guard';
import { AuthenticatedGuard } from './core/guards/authenticated.guard';

export const routes: Routes = [
    {
        path: 'dashboard',
        loadComponent: () => import('./shared/components/layout/layout.component'),
        children: [
            {
                path: '',
                loadComponent: () => import('./business/dashboard/dashboard.component'),
                //canActivate: [AuthGuard]
            },
            {
                path: 'profile',
                loadComponent: () => import('./business/profile/profile.component'),
                //canActivate: [AuthGuard]
            },
            {
                path: 'tables',
                loadComponent: () => import('./business/tables/tables.component'),
                //canActivate: [AuthGuard]
            },
            {
                path: 'categorias',
                loadComponent: () => import('./business/categorias/categorias.component')
                //canActivate: [AuthGuard]
            },

            {
                path: 'productos',
                loadComponent: () => import('./business/productos/productos.component'), 
                //canActivate: [AuthGuard]
            },
            {
                path: 'clientes',
                loadComponent: () => import('./business/clientes/clientes.component'), 
                //canActivate: [AuthGuard]
            },
            {
                path: 'compras',
                loadComponent: () => import('./business/compras/compras.component').then(m => m.default), 
            },
            {
                path: 'detalle-compras',
                loadComponent: () => import('./business/compras/compras.component').then(m => m.default),
            },



             {
                path: 'ventas',
                loadComponent: () => import('./business/ventas/ventas.component').then(m => m.VentasComponent), 
            },
            {
                path: 'detalle-ventas',
                loadComponent: () => import('./business/detalle-ventas/detalle-ventas.component').then(m => m.DetalleVentasComponent), 
            },

            {
                path: 'proveedores',
                loadComponent: () => import('./business/proveedores/proveedores.component'), 
            },
             // Rutas de USUARIOS
            { path: 'usuarios', loadComponent: () => import('./business/usuarios/usuarios.component') },
            { path: 'categorias', loadComponent: () => import('./business/categorias/categorias.component') },

            // { path: 'productos', loadComponent: () => import('./business/productos/productos.component') },
            
            { path: 'proveedores', loadComponent: () => import('./business/proveedores/proveedores.component') },
                ]
            },
            {
                path: 'login',
                loadComponent: ()=> import('./business/authentication/login/login.component'),
                //canActivate: [AuthenticatedGuard]
            },
            {
                path: '**',
                redirectTo: 'login'
            }
            
];