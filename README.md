# 🐾 Sistema de Gestión Veterinaria

Sistema web para la gestión de una clínica veterinaria, desarrollado con **Laravel 11** y la plantilla **SB Admin 2**.

## Requisitos

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Servidor web (Apache/Nginx)

## Instalación

```bash
# Clonar el repositorio
git clone <url-del-repositorio>
cd vet

# Instalar dependencias
composer install

# Copiar archivo de entorno y configurar base de datos
cp .env.example .env
php artisan key:generate

# Ejecutar migraciones y seeders
php artisan migrate:fresh --seed
```

## Usuarios de Prueba

| Usuario        | Contraseña     | Rol            |
|----------------|----------------|----------------|
| `admin`        | `admin`        | Administrador  |
| `veterinario`  | `veterinario`  | Veterinario    |

## Estructura del Proyecto

### Roles

El sistema maneja dos roles mediante un campo `enum` en la tabla `users`:

- **Administrador** — Accede al panel de administración (`/admin/home`) con sidebar oscuro. Enfocado en gestión de usuarios, veterinarios, reportes y configuración del sistema.
- **Veterinario** — Accede al dashboard clínico (`/home`) con sidebar azul. Enfocado en pacientes, consultas, propietarios e inventario.

### Protección por Rol

Se utiliza un middleware `CheckRole` que:
- Verifica que el usuario autenticado tenga el rol requerido para acceder a la ruta.
- Si el rol no coincide, redirige al dashboard correspondiente a su rol.
- Previene acceso cruzado entre paneles.

### Arquitectura de Vistas

```
resources/views/
├── layouts/
│   ├── app.blade.php                  ← Layout veterinario
│   ├── admin.blade.php                ← Layout administrador
│   ├── auth.blade.php                 ← Layout de autenticación
│   └── partials/
│       ├── sidebar.blade.php          ← Sidebar veterinario (azul)
│       ├── topbar.blade.php           ← Topbar veterinario
│       ├── footer.blade.php           ← Footer veterinario
│       └── admin/
│           ├── sidebar.blade.php      ← Sidebar administrador (oscuro)
│           ├── topbar.blade.php       ← Topbar administrador
│           └── footer.blade.php       ← Footer administrador
└── modules/
    ├── auth/
    │   └── login.blade.php            ← Página de login
    ├── dashboard/
    │   └── home.blade.php             ← Dashboard veterinario
    └── admin/
        └── dashboard.blade.php        ← Dashboard administrador
```

### Rutas Principales

| Método | URI           | Nombre       | Rol requerido  |
|--------|---------------|--------------|----------------|
| GET    | `/`           | `login`      | Invitado       |
| POST   | `/logear`     | `logear`     | Invitado       |
| GET    | `/home`       | `home`       | Veterinario    |
| GET    | `/admin/home` | `admin.home` | Administrador  |
| GET    | `/logout`     | `logout`     | Autenticado    |

## Tecnologías

- **Backend:** Laravel 11
- **Frontend:** SB Admin 2 (Bootstrap 4)
- **Base de datos:** MySQL
- **Iconos:** Font Awesome 5
- **Tipografía:** Nunito (Google Fonts)
