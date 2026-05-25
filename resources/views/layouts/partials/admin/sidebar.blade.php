<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Administración
    </div>

    <!-- Nav Item - Gestión de Usuarios -->
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Gestión de Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" aria-labelledby="headingUsuarios" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Listar usuarios</a>
                <a class="collapse-item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">Nuevo usuario</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Gestión de Veterinarios -->
    <li class="nav-item {{ request()->routeIs('admin.veterinarios.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.veterinarios.*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseVeterinarios"
            aria-expanded="{{ request()->routeIs('admin.veterinarios.*') ? 'true' : 'false' }}" aria-controls="collapseVeterinarios">
            <i class="fas fa-fw fa-user-md"></i>
            <span>Veterinarios</span>
        </a>
        <div id="collapseVeterinarios" class="collapse {{ request()->routeIs('admin.veterinarios.*') ? 'show' : '' }}" aria-labelledby="headingVeterinarios" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.veterinarios.index') ? 'active' : '' }}" href="{{ route('admin.veterinarios.index') }}">Listar veterinarios</a>
                <a class="collapse-item {{ request()->routeIs('admin.veterinarios.create') ? 'active' : '' }}" href="{{ route('admin.veterinarios.create') }}">Nuevo veterinario</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Padrón de Pacientes -->
    <li class="nav-item {{ request()->routeIs('admin.mascotas.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.mascotas.index') }}">
            <i class="fas fa-fw fa-paw"></i>
            <span>Padrón de Pacientes</span>
        </a>
    </li>

    <!-- Nav Item - Historial de Usuarios -->
    <li class="nav-item {{ request()->routeIs('admin.historial_usuarios.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.historial_usuarios.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Historial de usuarios</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
