# Explicación Didáctica del Navbar Principal y Enlaces de Acceso

## Introducción

El navbar principal (`app/Views/templates/Navbar.php`) es el componente de navegación global de la aplicación, incluido en todas las vistas públicas. Proporciona acceso a secciones informativas y enlaces de acceso para diferentes roles (Estudiantes, Profesores, Administradores). Este navbar usa Bootstrap para responsividad y PHP para URLs dinámicas.

Recuerda: El navbar no sigue MVC estricto, pero ilustra cómo las vistas incluyen templates compartidos.

## Estructura del Navbar

### Elementos Principales
- **Marca**: Logo y nombre del instituto, enlace a inicio.
- **Menú de Navegación**: Enlaces a secciones (Inicio, Quiénes Somos, etc.).
- **Dropdown Oferta Académica**: Enlaces a carreras específicas (usando JS para modales).
- **Dropdown Acceso**: Enlaces a páginas de acceso por rol.

#### Código clave:
```php
// Dropdown Acceso
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAcceso">
        <i class="fas fa-sign-in-alt me-1"></i> Acceso
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="<?= base_url('estudiantes'); ?>">Estudiantes</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="<?= base_url('registrarCarrera'); ?>">Profesores</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="<?= base_url('administradores'); ?>">Administradores</a></li>
    </ul>
</li>
```

**Lección didáctica**: El navbar centraliza navegación. `base_url()` genera URLs absolutas.

## Enlaces de Acceso

### Estudiantes: `base_url('estudiantes')`
- Enlaza a vista de login para estudiantes.
- Probablemente `app/Views/estudiantes.php`: Formulario de login con campos usuario/password, valida contra BD estudiantes.

### Profesores: `base_url('registrarCarrera')`
- Enlaza a `RegistrarCarrera` controller, posiblemente vista de registro/login para profesores.
- Nota: El enlace es a "registrarCarrera", no directamente a profesores, quizás para registro de carrera o login.

### Administradores: `base_url('administradores')`
- Enlaza a vista de login para administradores.
- Probablemente `app/Views/administradores.php`: Formulario de login, redirige a panel admin si ok.

## Flujo de Acceso

1. Usuario selecciona rol en dropdown.
2. Click en enlace → Navega a URL específica.
3. Vista carga formulario de login.
4. POST a controller (e.g., `Estudiantes::login`) → Valida credenciales → Redirige a panel correspondiente.

**Diagrama**:
```
Usuario → Navbar link → Vista login → Controller::login() → Panel
```

## Beneficios

- **Navegación clara**: Separa acceso por rol.
- **Inclusión global**: `<?= view('templates/Navbar') ?>` en todas las vistas públicas.
- **Responsivo**: Bootstrap colapsa en móvil.

## Conclusión

El navbar facilita acceso rol-específico. Para explicar: "El navbar incluye enlaces que llevan a vistas de login, donde el controller valida y redirige". Si las vistas no existen, créalas siguiendo patrones de login (form POST a controller).
