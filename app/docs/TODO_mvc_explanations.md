# TODO: Creación de Explicaciones Didácticas para MVC en CodeIgniter 4

Este archivo rastrea el progreso en la creación de documentación didáctica y completa sobre el patrón MVC en CodeIgniter 4, enfocada en cada vista principal de la aplicación. El objetivo es generar archivos MD que expliquen cómo funciona cada componente (Vista, Controlador, Modelo) para que puedas leerlos y explicar el MVC de manera clara.

## Pasos Generales del Plan
Basado en el análisis de la estructura del proyecto (carpetas app/Views, app/Controllers, app/Models), identificamos las vistas principales relacionadas con el panel administrativo y público. Para cada entidad/vista, crearemos un archivo MD único que cubra:
- **Vista**: Estructura HTML, cómo se renderiza y carga datos.
- **Controlador**: Lógica de negocio, métodos, interacción con modelos y vistas.
- **Modelo**: Manejo de datos, consultas a BD, validaciones.
- **Flujo MVC**: Cómo se integran en CodeIgniter 4 (rutas, carga de vistas, etc.).
- **Ejemplos didácticos**: Código snippets, diagramas textuales y explicaciones paso a paso.

Se crearán carpetas separadas para organizar las explicaciones:
- `app/docs/views_explanations/`: MD específicos de vistas.
- `app/docs/controllers_explanations/`: MD específicos de controladores.
- `app/docs/models_explanations/`: MD específicos de modelos.
- `app/docs/mvc_integrated/`: MD integrados por entidad (recomendado para explicaciones completas de MVC).

**Nota**: Usaremos la estructura integrada (un MD por entidad) para simplicidad y completitud, ya que explica el MVC holísticamente. Si prefieres separados, se puede ajustar.

## Entidades/Vistas Identificadas (Basado en Archivos Existentes)
De las vistas en `app/Views/` y `app/Views/administrador/`:
1. Usuarios (Vista: administrador/usuarios.php, Controlador: Usuarios.php, Modelo: UsuarioModel.php) - MD creado
2. Roles (Vista: administrador/rol.php, Controlador: Rol.php, Modelo: RolModel.php) - MD creado
3. Materias (Vista: administrador/materias.php, Controlador: Materias.php, Modelo: MateriaModel.php) - MD creado
4. Profesores (Vista: administrador/profesores.php, Controlador: Profesores.php, Modelo: ProfesorModel.php) - MD creado
5. Estudiantes (Vista: administrador/estudiantes.php, Controlador: Estudiantes.php, Modelo: EstudianteModel.php) - MD creado
6. Administradores (Vista: administradores.php, Controlador: Administradores.php, Modelo: AdministradorModel.php) - Vista creada, MD pendiente
7. Categorias (Vista: administrador/categorias.php, Controlador: Categorias.php, Modelo: CategoriaModel.php) - MD pendiente
8. Modalidades (Vista: administrador/modalidades.php, Controlador: Modalidades.php, Modelo: ModalidadModel.php) - MD pendiente
9. Carreras (Vista: ? (posiblemente en oferta académica), Controlador: Carreras.php o RegistrarCarrera.php, Modelo: CarreraModel.php) - MD pendiente
10. Otras vistas públicas (e.g., profesores.php, estudiantes.php, administradores.php) – Vistas creadas, MD creado para accesos
11. Navbar Principal (templates/Navbar.php) - MD creado

**Progreso Actual**: Ninguno completado.

## Pasos Lógicos a Seguir
1. [ ] Crear las carpetas de documentación:
   - app/docs/mvc_integrated/ (para MD integrados por entidad).

2. [ ] Para cada entidad (empezando por Usuarios):
   - [x] Usuarios: Leer archivos, generar MD, crear explicacion_usuarios.md.
   - [x] Roles: Leer archivos, generar MD, crear explicacion_roles.md.
   - [x] Materias: Leer archivos, generar MD, crear explicacion_materias.md.
   - [x] Profesores: Leer archivos, generar MD, crear explicacion_profesores.md.
   - [x] Estudiantes: Leer archivos, generar MD, crear explicacion_estudiantes.md.
   - [ ] Las demás entidades (Administradores, Categorias, Modalidades, Carreras) siguen el mismo patrón MVC: leer archivos, generar MD similar con detalles específicos.
   - [ ] Actualizar este TODO con [x] al completarse.

3. [ ] Después de todas las entidades:
   - [ ] Crear un MD general: explicacion_mvc_general.md resumiendo el patrón MVC en CI4 con referencias a los específicos.
   - [ ] Separar paneles por vista: Si es necesario, mover/organizar vistas en subcarpetas (e.g., app/Views/panel_admin/ y app/Views/panel_publico/).
   - [ ] Verificar y probar: Asegurar que las explicaciones sean didácticas (con secciones, código, diagramas ASCII).

4. [ ] Pasos de seguimiento:
   - Instalar dependencias si needed (ninguna por ahora).
   - Probar carga de vistas en browser si aplica.
   - Actualizar README.md del proyecto con enlaces a docs.

**Próximo Paso Inmediato**: Crear las carpetas y empezar con la primera entidad (Usuarios).
