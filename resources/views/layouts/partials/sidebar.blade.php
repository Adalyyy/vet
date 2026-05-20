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
        Detalles Médicos
    </div>

    <!-- Nav Item - Diagnóstico -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Diagnóstico de la consulta</span>
        </a>
    </li>

    <!-- Nav Item - Tratamiento -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-pills"></i>
            <span>Tratamiento de la consulta</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Historial Clínico
    </div>

    <!-- Nav Item - Antecedentes Alergias -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-allergies"></i>
            <span>Antecedentes Alergias</span>
        </a>
    </li>

    <!-- Nav Item - Antecedentes Lesiones -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-band-aid"></i>
            <span>Antecedentes Lesiones</span>
        </a>
    </li>

    <!-- Nav Item - Antecedentes Patológicos -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-virus"></i>
            <span>Antecedentes Patológicos</span>
        </a>
    </li>

    <!-- Nav Item - Historial Alimentación -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-bone"></i>
            <span>Historial Alimentación</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
