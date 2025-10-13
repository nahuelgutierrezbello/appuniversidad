# Flujo Completo y Didáctico de Registro de un Rol en CodeIgniter 4

## Introducción

Registro simple de rol (solo nombre). Muestra flujo básico CRUD.

## Paso 1: Acceso a Vista Roles

### Admin a "Roles".

### Controlador `Rol::index()`
- Carga roles.

#### Código:
```php
public function index()
{
    $data['roles'] = $this->rolModel->findAll();
    return view('administrador/rol', $data);
}
```

## Paso 2: Ingreso Nombre

- Nombre "Profesor".

## Paso 3: POST a `rol/registrar`

### Controlador `Rol::registrar()`
- Recoge nombre_rol, save().

#### Código:
```php
public function registrar()
{
    $data = ['nombre_rol' => $this->request->getPost('nombre_rol')];
    if ($this->rolModel->save($data)) {
        return redirect()->to('/administrador/rol')->with('success', 'Rol registrado.');
    } else {
        return redirect()->back()->withInput()->with('errors', $this->rolModel->errors());
    }
}
```

## Paso 4: Modelo `RolModel`

- **Campos**: nombre_rol.
- **Validaciones**: required, unique.
- **save()**: Valida, inserta.

## Paso 5: Redirect

- Tabla actualizada.

## Conclusión

Flujo básico para entidades simples.
