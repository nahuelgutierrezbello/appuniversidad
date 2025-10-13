# Explicación Didáctica de las Vistas de Acceso (Estudiantes, Profesores, Administradores)

## Introducción

Las vistas de acceso (`app/Views/estudiantes.php`, `profesores.php`, `administradores.php`) son páginas públicas de login para cada rol. Incluyen el navbar principal y un formulario de login que POST a controllers específicos. Muestran cómo MVC maneja autenticación básica.

Recuerda: Estas vistas son públicas, sin navbar admin.

## Estructura Común de las Vistas de Acceso

### Elementos Compartidos
- **Navbar Principal**: `<?= view('templates/Navbar') ?>` para navegación global.
- **Header**: Título y descripción específica por rol.
- **Formulario de Login**: Campos username/password, CSRF, POST a controller/login.
- **Footer**: Igual en todas.

#### Código clave (Ejemplo Estudiantes):
```php
<form id="loginForm" method="post" action="<?= base_url('estudiantes/login') ?>">
    <?= csrf_field() ?>
    <input type="text" id="username" name="username" required /> <!-- DNI para estudiantes -->
    <input type="password" id="password" name="password" required />
    <button type="submit">Ingresar</button>
</form>
```

**Lección didáctica**: Formularios usan `base_url()` para rutas, CSRF para seguridad.

## Diferencias por Rol

### Estudiantes (`estudiantes.php`)
- **Usuario**: DNI (8 dígitos).
- **Acción**: `estudiantes/login`.
- **Color**: Azul (primary).
- **Icono**: user-graduate.

### Profesores (`profesores.php`)
- **Usuario**: Legajo.
- **Acción**: `profesores/login`.
- **Color**: Verde (success).
- **Icono**: chalkboard-teacher.

### Administradores (`administradores.php`)
- **Usuario**: Username genérico.
- **Acción**: `administradores/login`.
- **Color**: Amarillo (warning).
- **Icono**: user-shield.

## Flujo MVC en Acceso

1. Usuario click en navbar → Carga vista login.
2. Ingresa credenciales → POST a controller.
3. Controller valida (e.g., check BD) → Si ok, session + redirect a panel; else, error.

**Diagrama**:
```
Navbar link → Vista login → Controller::login() → Validación → Panel o Error
```

## Beneficios

- **Separación por rol**: Diferentes controllers para lógica específica.
- **Seguridad**: CSRF, validación server-side.
- **UX**: Mensajes de error, responsivo.

## Conclusión

Las vistas de acceso facilitan login rol-específico. Para explicar: "La vista muestra form, controller valida credenciales, modelo check BD". Controllers necesitan métodos login para completar.
