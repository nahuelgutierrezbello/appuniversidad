# Explicación Didáctica del Patrón MVC en CodeIgniter 4: Gestión de Roles

## Introducción

Continuando con las explicaciones didácticas del patrón MVC en CodeIgniter 4, ahora exploramos el módulo de **Gestión de Roles**. Los roles definen permisos en el sistema (e.g., Administrador, Profesor, Estudiante), y este módulo permite crear, editar, eliminar y buscar roles. Usaremos este ejemplo para reforzar cómo MVC separa responsabilidades, facilitando explicaciones claras sobre cómo CI4 maneja la lógica de aplicación.

Recuerda: MVC divide en Modelo (datos), Vista (UI), Controlador (lógica). En CI4, esto se traduce en archivos organizados que promueven código limpio y mantenible.

## Estructura del Módulo de Roles en MVC

### Vista: `app/Views/administrador/rol.php`

La vista presenta la interfaz para gestionar roles: formularios para registrar/buscar, tabla de listado y modal de edición. Es HTML con PHP mínimo para iterar datos.

#### Funcionalidades clave:
- **Registro**: Formulario simple con campo "Nombre del Rol".
- **Búsqueda**: Input para ID, muestra detalles dinámicamente.
- **Listado**: Tabla con roles, botones de editar/eliminar.
- **Edición**: Modal con formulario para actualizar nombre.
- **Interfaz**: Bootstrap para responsividad, DataTables para tablas, JS para AJAX.

#### Código relevante:
```php
// Bucle para mostrar roles en tabla
<?php foreach($roles as $rol): ?>
    <tr>
        <td><?= esc($rol['id']) ?></td>
        <td><?= esc($rol['nombre_rol']) ?></td>
        // Botones de acción
    </tr>
<?php endforeach; ?>

// Formulario POST al controlador
<form method="post" action="<?= base_url('rol/registrar') ?>">
    <?= csrf_field() ?>  // Seguridad anti-CSRF
    <input name="nombre_rol" required />
</form>
```

**Lección didáctica**: La vista no procesa datos; solo los muestra. Cambios en el diseño (e.g., agregar íconos) no afectan el controlador o modelo.

### Controlador: `app/Controllers/Rol.php`

El controlador maneja solicitudes HTTP, valida input y coordina con el modelo. Extiende `BaseController` de CI4.

#### Métodos:
- **`index()`**: Carga roles del modelo, pasa a vista.
- **`registrar()`**: Procesa POST, inserta vía modelo, redirige con mensaje.
- **`edit($id)` / `update($id)`**: Para edición (JSON para AJAX, POST para guardar).
- **`delete($id)`**: Elimina rol.
- **`search($id)`**: Busca y devuelve JSON.

#### Ejemplo de código:
```php
public function registrar()
{
    $data = ['nombre_rol' => $this->request->getPost('nombre_rol')];
    if ($this->rolModel->insert($data)) {
        return redirect()->to('/administrador/rol')->with('success', 'Rol registrado.');
    } else {
        return redirect()->back()->withInput()->with('errors', $this->rolModel->errors());
    }
}
```

**Lección didáctica**: El controlador es el "director": recibe input, llama al modelo para operaciones de BD, decide qué vista mostrar. No toca HTML ni queries directas.

### Modelo: `app/Models/RolModel.php`

El modelo encapsula acceso a datos. Extiende `CodeIgniter\Model` para CRUD automático.

#### Características:
- **Tabla**: `$table = 'Rol'`.
- **Campos permitidos**: `$allowedFields = ['nombre_rol']`.
- **Validación**: Reglas para nombre único, longitud mínima/máxima.
- **Métodos heredados**: `findAll()`, `insert()`, `update()`, `delete()`.

#### Código:
```php
class RolModel extends Model
{
    protected $validationRules = [
        'nombre_rol' => 'required|min_length[2]|max_length[20]|is_unique[Rol.nombre_rol,id,{id}]',
    ];
}
```

**Lección didáctica**: El modelo protege la integridad de datos. Validaciones evitan duplicados o entradas inválidas. Cambios en BD (e.g., agregar campo) se hacen aquí.

## Flujo MVC en el Módulo de Roles

1. **Usuario visita**: `/administrador/rol` → Ruta llama `Rol::index()`.
2. **Controlador index()**: `$roles = $this->rolModel->findAll()` → Pasa a vista.
3. **Vista renderiza**: Muestra tabla con roles.
4. **Usuario registra**: POST a `/rol/registrar` → `Rol::registrar()`.
5. **Controlador valida**: Llama `$this->rolModel->insert($data)`.
6. **Modelo valida/inserta**: Si ok, devuelve true; sino, errores.
7. **Respuesta**: Redirige a index con flash message.

**Diagrama**:
```
Usuario → Ruta → Controlador::registrar() → Modelo::insert() → BD
                    ↓
Vista (con mensaje) ← Controlador (redirect)
```

## Beneficios y Comparación con Usuarios

Similar a Usuarios, pero más simple (sin password/activo). Muestra cómo MVC escala: mismo patrón, lógica adaptada. Beneficios:
- **Modularidad**: Cambia vista sin afectar modelo.
- **Seguridad**: Validaciones y CSRF integradas.
- **Reutilización**: Modelo usado en otros controladores (e.g., asignar rol a usuario).
- **Facilita explicaciones**: "El modelo guarda, el controlador decide, la vista muestra".

## Conclusión

El módulo de Roles refuerza MVC: vista para UI, controlador para flujo, modelo para datos. En CI4, esto se logra con convenciones simples. Para explicar, compara con Usuarios: mismo flujo, pero datos diferentes. Próximo: Materias o Profesores para más variaciones.
