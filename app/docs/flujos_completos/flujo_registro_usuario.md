# Flujo Completo y Didáctico de Registro de un Usuario en CodeIgniter 4

## Introducción

Este documento explica paso a paso el registro de un usuario (admin/profesor/estudiante) en el panel admin. Desde vista, ingreso datos, validación, BD, hasta actualización tabla. Similar al estudiante, pero con password hash y rol.

## Paso 1: Acceso a la Vista de Usuarios

### Usuario (Administrador)
- Admin accede a "Usuarios" en panel admin.

### Ruta y Controlador
- **Ruta**: `/administrador/usuarios`.
- **Controlador**: `Usuarios::index()`.
- **Acción**: Carga usuarios y roles.

#### Código:
```php
public function index()
{
    $data['usuarios'] = $this->usuarioModel->findAll();
    $data['roles'] = $this->db->table('Rol')->get()->getResultArray();
    return view('administrador/usuarios', $data);
}
```

### Vista
- Form: username, password, rol select.
- Tabla: lista usuarios.

## Paso 2: Ingreso de Datos

### Usuario
- Llena: username "admin2", password "123456", rol "Administrador".
- Submit.

### Form
```html
<form method="post" action="<?= base_url('usuarios/registrar') ?>">
    <input name="username" required />
    <input type="password" name="password" required />
    <select name="id_rol">...</select>
    <button>Registrar</button>
</form>
```

## Paso 3: Procesamiento en Controlador

### POST a `usuarios/registrar`
El controlador recibe la petición POST, prepara los datos incluyendo el hash de la password para seguridad, llama al modelo para validación e inserción, y maneja el resultado con redirecciones.

#### Explicación paso a paso del código:
```php
public function registrar()
{
    // Prepara array de datos del form.
    $data = [
        'username' => $this->request->getPost('username'),  // Nombre usuario (debe ser único)
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),  // Hash seguro con bcrypt
        'id_rol' => $this->request->getPost('id_rol'),      // ID del rol seleccionado
    ];

    // Llama save() del modelo: valida username único, inserta si ok.
    if ($this->usuarioModel->save($data)) {
        // Éxito: redirect a lista usuarios con mensaje success.
        return redirect()->to('/administrador/usuarios')->with('success', 'Usuario registrado.');
    } else {
        // Error: redirect back manteniendo input, pasando errores para mostrar.
        return redirect()->back()->withInput()->with('errors', $this->usuarioModel->errors());
    }
}
```

**¿Por qué es didáctico?** El hash de password es crucial para seguridad (no guarda texto plano). Controlador coordina input → modelo → resultado. withInput() preserva datos en error, mejorando UX. Modelo valida unicidad para evitar duplicados.

## Paso 4: Validación y Guardado en Modelo

### `UsuarioModel`
- **Campos**: username, password, id_rol.
- **Validaciones**: username unique, password required.
- **save()**: Valida, inserta en 'Usuario'.

#### Código:
```php
protected $validationRules = [
    'username' => 'required|is_unique[Usuario.username,id_usuario,{id_usuario}]',
    'password' => 'required',
    'id_rol' => 'required|integer',
];
```

## Paso 5: Redirección y Actualización

- Redirect a `/administrador/usuarios`.
- Tabla actualizada con nuevo usuario.
- Mensaje success.

## Diagrama

```
Vista form → POST → Controlador → Modelo (hash + validate + insert) → Redirect → Vista tabla
```

## Conclusión

Similar a estudiante, pero con hash password. Muestra seguridad en MVC.
