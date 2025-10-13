# Explicación Didáctica del Patrón MVC en CodeIgniter 4: Gestión de Usuarios

## Introducción

En esta explicación, exploraremos cómo funciona el patrón de diseño **Modelo-Vista-Controlador (MVC)** en el framework **CodeIgniter 4 (CI4)**, utilizando como ejemplo práctico el módulo de **Gestión de Usuarios** de la aplicación universitaria. El objetivo es que puedas entender y explicar claramente cómo se separan las responsabilidades en una aplicación web moderna, facilitando el mantenimiento, escalabilidad y reutilización del código.

El módulo de Usuarios permite registrar, editar, eliminar y buscar usuarios del sistema, asignándoles roles (como administrador, profesor o estudiante). A través de este ejemplo, verás cómo CI4 implementa MVC de manera elegante y eficiente.

## ¿Qué es el Patrón MVC?

MVC es un patrón de arquitectura de software que divide una aplicación en tres componentes principales:

- **Modelo (Model)**: Maneja los datos y la lógica de negocio. Interactúa con la base de datos.
- **Vista (View)**: Presenta la información al usuario (HTML, CSS, JS). Es la interfaz.
- **Controlador (Controller)**: Actúa como intermediario. Recibe las solicitudes del usuario, procesa la lógica (usando modelos) y decide qué vista mostrar.

En CI4, MVC se implementa de forma estricta:
- Los controladores están en `app/Controllers/`.
- Las vistas en `app/Views/`.
- Los modelos en `app/Models/`.

Esto promueve la separación de preocupaciones: cambios en la vista no afectan el modelo, y viceversa.

## Estructura del Módulo de Usuarios en MVC

### Vista: `app/Views/administrador/usuarios.php`

La vista es el archivo HTML que el usuario ve en el navegador. En CI4, las vistas son archivos PHP que combinan HTML con código PHP mínimo (principalmente para bucles y condicionales).

#### ¿Qué hace esta vista?
- **Muestra datos**: Lista todos los usuarios en una tabla, con información como ID, nombre de usuario, rol y estado (activo/inactivo).
- **Formularios para interacción**: 
  - Formulario de registro de nuevo usuario (con campos para usuario, contraseña, rol y checkbox de activo).
  - Formulario de búsqueda por ID.
  - Modal para editar usuario existente.
- **Interfaz dinámica**: Usa Bootstrap para diseño responsivo, DataTables para tablas interactivas, y JavaScript para AJAX (carga asíncrona sin recargar la página).
- **Manejo de errores**: Muestra mensajes de error de validación (e.g., "El nombre de usuario ya existe") usando sesiones flash de CI4.

#### Código clave en la vista:
```php
// Carga datos desde el controlador
<?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?= esc($usuario['id']) ?></td>
        <td><?= esc($usuario['usuario']) ?></td>
        // ... más celdas
    </tr>
<?php endforeach; ?>

// Formulario que envía POST al controlador
<form id="usuarioForm" method="post" action="<?= base_url('usuarios/registrar') ?>">
    <?= csrf_field() ?>  // Protección CSRF de CI4
    // Campos del formulario
</form>
```

**¿Por qué es didáctico?** La vista no contiene lógica de negocio; solo presenta datos pasados por el controlador. Esto hace que sea fácil cambiar el diseño sin tocar el backend.

### Controlador: `app/Controllers/Usuarios.php`

El controlador es el "cerebro" del módulo. Recibe las peticiones HTTP (GET, POST), valida datos, interactúa con modelos y decide qué vista renderizar.

#### Métodos principales:
- **`index()`**: Método por defecto. Carga todos los usuarios y roles desde los modelos, pasa los datos a la vista `administrador/usuarios`.
- **`registrar()`**: Maneja POST para crear usuario. Valida datos, hashea contraseña, inserta en BD vía modelo. Redirige con mensaje de éxito/error.
- **`edit($id)` y `update($id)`**: Para edición. `edit` devuelve JSON para AJAX; `update` procesa cambios.
- **`delete($id)`**: Elimina usuario.
- **`search($id)`**: Busca usuario por ID y devuelve JSON.

#### Código clave:
```php
public function index()
{
    $data['usuarios'] = $this->usuarioModel->findAll();  // Carga desde modelo
    $data['roles'] = $this->rolModel->findAll();
    return view('administrador/usuarios', $data);  // Renderiza vista con datos
}

public function registrar()
{
    $data = [
        'usuario' => $this->request->getPost('usuario'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),  // Seguridad
        // ...
    ];
    if ($this->usuarioModel->insert($data)) {
        return redirect()->to('/administrador/usuarios')->with('success', 'Usuario registrado exitosamente.');
    } else {
        return redirect()->back()->withInput()->with('errors', $this->usuarioModel->errors());
    }
}
```

**¿Por qué es didáctico?** El controlador no toca la BD directamente (eso es del modelo). Solo coordina: recibe input, valida, llama al modelo, redirige. Facilita testing y reutilización.

### Modelo: `app/Models/UsuarioModel.php`

El modelo representa la capa de datos. Extiende `CodeIgniter\Model` para funcionalidades automáticas como CRUD.

#### Funcionalidades:
- **Tabla y campos**: Define `$table = 'Usuarios'`, `$primaryKey = 'id'`, `$allowedFields` (campos permitidos para insert/update).
- **Validación**: Reglas en `$validationRules` (e.g., usuario único, contraseña mínima 6 chars). Mensajes personalizados en `$validationMessages`.
- **Métodos automáticos**: `findAll()`, `insert()`, `update()`, `delete()` heredados de CI4.

#### Código clave:
```php
class UsuarioModel extends Model
{
    protected $table = 'Usuarios';
    protected $allowedFields = ['usuario', 'password', 'rol_id', 'activo'];

    protected $validationRules = [
        'usuario' => 'required|min_length[3]|max_length[50]|is_unique[Usuarios.usuario,id,{id}]',
        'password' => 'required|min_length[6]',
        // ...
    ];
}
```

**¿Por qué es didáctico?** El modelo encapsula toda la lógica de datos. Cambios en la BD (e.g., agregar campo) solo afectan aquí, sin tocar vistas o controladores.

## Flujo de una Solicitud en MVC (Ejemplo: Registrar Usuario)

1. **Usuario accede**: Navega a `/administrador/usuarios` (ruta definida en `Routes.php` apunta a `Usuarios::index`).
2. **Controlador index()**: Llama a modelos para obtener `$usuarios` y `$roles`.
3. **Vista renderizada**: CI4 combina la vista con datos, genera HTML.
4. **Usuario llena formulario**: Envía POST a `/usuarios/registrar`.
5. **Controlador registrar()**: Valida input, hashea password, llama `$this->usuarioModel->insert($data)`.
6. **Modelo valida e inserta**: Si pasa validaciones, inserta en BD; sino, devuelve errores.
7. **Respuesta**: Controlador redirige a index con mensaje flash. Vista muestra éxito/error.

**Diagrama textual**:
```
Usuario -> Ruta (/usuarios/registrar) -> Controlador::registrar() -> Modelo::insert() -> BD
                                                                 |
                                                                 v
Vista (con mensaje) <- Controlador (redirige) <- Modelo (errores/success)
```

## Beneficios del MVC en CI4 para este Módulo

- **Separación clara**: Vista solo UI, Controlador lógica, Modelo datos. Fácil mantenimiento.
- **Reutilización**: Modelo se usa en otros controladores (e.g., login).
- **Seguridad**: CSRF, validaciones, hashing de passwords integrado.
- **Escalabilidad**: Agregar features (e.g., paginación) solo requiere cambios en controlador/modelo.
- **Testing**: Cada componente se prueba por separado.
- **Framework ayuda**: CI4 provee helpers como `redirect()`, `view()`, `session()`.

## Conclusión

El módulo de Usuarios ilustra perfectamente cómo CI4 implementa MVC: el controlador orquesta, el modelo maneja datos, la vista presenta. Esto hace el código modular y profesional. Para explicar a otros, enfócate en la separación: "La vista es lo que ves, el controlador decide qué hacer, el modelo guarda/carga datos". Practica modificando la vista (cambia colores) sin afectar la lógica, o agrega validaciones en el modelo.

**Próximo paso**: Explora otros módulos como Roles o Profesores para ver variaciones en MVC.
