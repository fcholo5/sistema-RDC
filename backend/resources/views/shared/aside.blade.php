<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route("login") }}"> {{-- Asumiendo que 'login' es tu dashboard/inicio --}}
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#ventas-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Ventas</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="ventas-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('venta.index') }}">
                        <i class="bi bi-circle"></i><span>Vender producto</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('detalle_ventas.index') }}">
                        <i class="bi bi-circle"></i><span>Consultar Ventas</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Ventas Nav -->

        {{-- Nueva sección para Compras --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('compras.index') }}">
                <i class="bi bi-cart"></i> {{-- Icono de carrito de compras --}}
                <span>Compras</span>
            </a>
        </li><!-- End Compras Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('categorias') }}">
                <i class="bi bi-card-list"></i>
                <span>Categorias</span>
            </a>
        </li><!-- End Categorias Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('productos') }}"> {{-- Corregido a productos.index --}}
                <i class="bi bi-box-arrow-in-right"></i> {{-- Este icono podría ser más apropiado para 'ingreso' o 'stock' --}}
                <span>Productos</span>
            </a>
        </li><!-- End Productos Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('clientes') }}">
                <i class="bi bi-people"></i> {{-- Icono más apropiado para clientes --}}
                <span>Clientes</span>
            </a>
        </li><!-- End Clientes Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('proveedores') }}">
                <i class="bi bi-truck"></i> {{-- Icono más apropiado para proveedores --}}
                <span>Proveedores</span>
            </a>
        </li><!-- End Proveedores Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('usuarios') }}">
                <i class="bi bi-person-circle"></i> {{-- Icono más apropiado para usuarios --}}
                <span>Usuarios</span>
            </a>
        </li><!-- End Usuarios Nav -->

    </ul>

</aside><!-- End Sidebar-->
