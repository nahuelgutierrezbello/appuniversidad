# Flujo Completo y Didáctico de Registro de un Profesor en CodeIgniter 4

## Introducción

Registro de profesor con legajo único, nombre y carrera. Similar a estudiante, pero con legajo en lugar de DNI.

## Paso 1: Acceso a Vista Profesores

### Admin a "Profesores".

### Controlador `Profesores::index()`
- Carga profesores y carreras.

#### Código:
```php
public function index()
{
    $profesorModel = new ProfesorModel();
    $data['profesores'] = $profesorModel->getProfesores();
    $data['carreras'] = $this->db->table('Carrera')->get()->getResultArray();
    return view('administrador/profesores', $data);
}
```

## Paso 2: Ingreso Datos

- Legajo "12345", Nombre "Dr. Juan Pérez", Carrera "Ingeniería".

## Paso 3: POST a `profesores/registrar`

### Controlador `Profesores::registrar()`
El controlador recibe la petición POST del formulario. Su rol es recoger los datos enviados, validar a través del modelo, y decidir qué hacer: guardar o mostrar errores.

#### Explicación paso a paso del código:
```php
public function registrar()
{
    // Crea una instancia del modelo para interactuar con la BD.
    $profesorModel = new ProfesorModel();

    // Recoge los datos del formulario usando el objeto request de CI4.
    // getPost() obtiene valores del array $_POST, sanitizados automáticamente.
    $data = [
        'legajo' => $this->request->getPost('legajo'),  // Campo único, e.g., "12345"
        'nprof'  => $this->request->getPost('nprof'),   // Nombre completo, e.g., "Dr. Juan Pérez"
        'carrera_id' => $this->request->getPost('carrera_id'),  // ID de carrera seleccionada
    ];

    // Llama a save() del modelo. Este método valida los datos según reglas en el modelo.
    // Si validación falla, save() devuelve false y errors() contiene mensajes.
    if ($profesorModel->save($data) === false) {
        // Redirige de vuelta al form, mantiene input del usuario, pasa errores para mostrar.
        return redirect()->to('/profesores')->withInput()->with('errors', 'Error al registrar: ' . implode(', ', $profesorModel->errors()));
    }

    // Si save() es true, datos guardados. Redirige a lista con mensaje éxito.
    return redirect()->to('/profesores')->with('success', 'Profesor registrado correctamente.');
}
```

**¿Por qué es didáctico?** El controlador no toca la BD directamente (eso es modelo). Solo coordina: input → validación → resultado. `withInput()` evita que usuario reescriba datos si hay error. `with('errors')` pasa array de errores a vista para mostrar en alert.

## Paso 4: Modelo `ProfesorModel`

- **Campos**: legajo, nprof, carrera_id.
- **Validaciones**: legajo unique, required.
- **save()**: Valida, inserta.

## Paso 5: Redirect

- Tabla actualizada con nuevo profesor.

## Conclusión

Similar a estudiante, con legajo único.
