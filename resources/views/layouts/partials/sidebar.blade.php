<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">VETERINARIA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Inicio</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Directorio
    </div>

    <!-- Nav Item - Dueños -->
    <li class="nav-item {{ request()->routeIs('duenos.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('duenos.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Dueños / Propietarios</span>
        </a>
    </li>

    <!-- Nav Item - Mascotas -->
    <li class="nav-item {{ request()->routeIs('mascotas.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mascotas.index') }}">
            <i class="fas fa-fw fa-dog"></i>
            <span>Mascotas</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pacientes
    </div>

    <!-- Nav Item - Atender Mascota -->
    <li class="nav-item {{ request()->routeIs('atender.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('atender.index') }}">
            <i class="fas fa-fw fa-notes-medical"></i>
            <span>Atender Mascota</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestión Clínica
    </div>

    <!-- Agenda / Citas -->
    <li class="nav-item {{ request()->routeIs('citas.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('citas.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Agenda / Citas</span>
        </a>
    </li>

    <!-- Configuración -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Configuración</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
