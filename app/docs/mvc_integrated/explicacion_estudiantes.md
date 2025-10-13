# Explicación Didáctica del Patrón MVC en CodeIgniter 4: Gestión de Estudiantes

## Introducción

El módulo de **Gestión de Estudiantes** maneja alumnos con datos personales (DNI, email, edad) y asignación a carreras. Destaca validaciones complejas (DNI único, email válido), búsquedas por carrera (devuelve múltiples), y formularios extensos. Muestra MVC para entidades con más campos y relaciones.

## Estructura del Módulo de Estudiantes en MVC

### Vista: `app/Views/administrador/estudiantes.php`

Vista con formulario registro (campos múltiples), búsquedas (ID y carrera), tabla detallada, modal edición.

#### Funcionalidades:
- **Registro**: Nombre, DNI (8 dígitos), edad, email, fecha_nac, carrera.
- **Búsqueda por ID**: Detalles de uno.
- **Búsqueda por carrera**: Lista estudiantes en esa carrera.
- **Listado**: Tabla con ID, nombre, DNI, edad, email, carrera.

#### Código clave:
```php
// Búsqueda por carrera
<select id="searchCareer">
    <?php foreach($carreras as $car): ?>
        <option value="<?= esc($car['id_car']) ?>"><?= esc($car['ncar']) ?></option>
    <?php endforeach; ?>
</select>
```

**Lección**: Vista maneja formularios complejos, datos relacionados.

### Controlador: `app/Controllers/Estudiantes.php`

Controlador con métodos para búsquedas variadas.

#### Métodos:
- **`index()`**: Carga estudiantes y carreras.
- **`registrar()`**: Inserta con validación.
- **`edit/update/delete`**: CRUD.
- **`search($id)`**: Por ID.
- **`searchByCareer($id_car)`**: Devuelve array de estudiantes.

#### Código clave:
```php
public function searchByCareer($id_car)
{
    $estudiantes = $this->estudianteModel->getEstudiantesByCarrera($id_car);
    return $this->response->setJSON($estudiantes ?: []);
}
```

**Lección**: Controlador maneja queries complejas, respuestas JSON arrays.

### Modelo: `app/Models/EstudianteModel.php`

Modelo con validaciones avanzadas, métodos custom.

#### Características:
- **Campos**: nest, dni, edad, email, fecha_nac, id_car.
- **Validación**: DNI único, email válido, edad numérica.
- **Métodos**: `getEstudiantesByCarrera($id_car)`.

#### Código:
```php
protected $validationRules = [
    'dni' => 'required|exact_length[8]|is_unique[Estudiante.dni,id_est,{id_est}]',
    'email' => 'required|valid_email',
    // ...
];
```

**Lección**: Modelo valida datos complejos, queries relacionadas.

## Flujo MVC en Estudiantes

1. **Búsqueda por carrera**: AJAX → Controlador llama modelo → JSON array → Vista muestra lista.
2. **Registro**: POST con campos múltiples → Validación → Insert.

**Diagrama**:
```
Usuario → Controlador::searchByCareer() → Modelo::getEstudiantesByCarrera() → JSON[]
```

## Beneficios y Comparación

Más campos y búsquedas. Muestra MVC para datos personales. Beneficios: validaciones robustas, queries eficientes.

## Conclusión

Estudiantes ilustra MVC para entidades detalladas. Para explicar: "El modelo valida email/DNI, controlador busca por carrera, vista muestra múltiples". Las demás entidades siguen patrones similares.
