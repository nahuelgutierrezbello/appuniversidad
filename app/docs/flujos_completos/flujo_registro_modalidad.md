# Flujo Completo y Didáctico de Registro de una Modalidad en CodeIgniter 4

## Introducción

Registro de modalidad con código, nombre y carrera relacionada. Muestra relaciones simples.

## Paso 1: Acceso a Vista Modalidades

### Admin a "Modalidades".

### Controlador `Modalidades::index()`
- Carga modalidades y carreras.

#### Código:
```php
public function index()
{
    $data['modalidades'] = $this->modalidadModel->findAll();
    $data['carreras'] = $this->carreraModel->findAll();
    return view('administrador/modalidades', $data);
}
```

## Paso 2: Ingreso Datos

- Código "PRES", Nombre "Presencial", Carrera "Ingeniería".

## Paso 3: POST a `modalidades/registrar`

### Controlador `Modalidades::registrar()`
- Recoge datos, insert().

#### Código:
```php
public function registrar()
{
    $data = [
        'codigo_modalidad' => $this->request->getPost('codigo_modalidad'),
        'nombre_modalidad' => $this->request->getPost('nombre_modalidad'),
        'carrera_id' => $this->request->getPost('carrera_id'),
    ];
    if ($this->modalidadModel->insert($data)) {
        return redirect()->to('/administrador/modalidades')->with('success', 'Modalidad registrada exitosamente.');
    } else {
        return redirect()->back()->withInput()->with('errors', $this->modalidadModel->errors());
    }
}
```

## Paso 4: Modelo `ModalidadModel`

- **Campos**: codigo_modalidad, nombre_modalidad, carrera_id.
- **Validaciones**: required, unique si aplica.
- **insert()**: Valida, inserta.

## Paso 5: Redirect

- Tabla actualizada.

## Conclusión

Similar a materia, con relación a carrera.
