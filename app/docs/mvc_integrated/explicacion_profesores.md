# Explicación Didáctica del Patrón MVC en CodeIgniter 4: Gestión de Profesores

## Introducción

Exploramos el módulo de **Gestión de Profesores**, que maneja docentes con legajo único y asignación a carreras. Este ejemplo destaca búsquedas múltiples (por ID y legajo), validaciones personalizadas y métodos modelo custom. Refuerza cómo MVC maneja entidades complejas en CI4.

Recuerda: Modelo para datos, Vista para UI, Controlador para lógica.

## Estructura del Módulo de Profesores en MVC

### Vista: `app/Views/administrador/profesores.php`

Vista con formularios de registro (con carrera), dos búsquedas (ID y legajo), tabla de listado, modal edición.

#### Funcionalidades:
- **Registro**: Nombre, legajo, carrera.
- **Búsqueda dual**: Por ID o legajo, muestra detalles.
- **Listado**: Tabla con ID, nombre, legajo.
- **Edición**: Modal para actualizar.

#### Código clave:
```php
// Búsqueda por legajo
<form id="searchProfByLegajoForm">
    <input id="searchProfLegajo" name="legajo" />
</form>
```

**Lección**: Vista maneja UI múltiple, datos dinámicos.

### Controlador: `app/Controllers/Profesores.php`

Controlador con métodos para búsquedas múltiples, comentarios detallados.

#### Métodos:
- **`index()`**: Carga profesores y carreras.
- **`registrar()`**: Inserta con validación.
- **`edit/update/delete`**: CRUD.
- **`search($id)` / `searchByLegajo($legajo)`**: Devuelven JSON para AJAX.

#### Código clave:
```php
public function searchByLegajo($legajo)
{
    if ($this->request->isAJAX()) {
        $profesor = $this->profesorModel->getProfesorByLegajo($legajo);
        return $this->response->setJSON($profesor ?: ['error' => 'No encontrado']);
    }
}
```

**Lección**: Controlador maneja múltiples endpoints, valida AJAX.

### Modelo: `app/Models/ProfesorModel.php`

Modelo con métodos custom para búsquedas.

#### Características:
- **Campos**: legajo, nprof, carrera_id.
- **Validación**: Legajo único, nombre longitud.
- **Métodos**: `getProfesores()`, `getProfesor($id)`, `getProfesorByLegajo($legajo)`.

#### Código:
```php
public function getProfesorByLegajo($legajo)
{
    return $this->where('legajo', $legajo)->first();
}
```

**Lección**: Modelo encapsula queries custom, validaciones.

## Flujo MVC en Profesores

1. **Búsqueda por legajo**: AJAX a `searchByLegajo/123` → Modelo busca → JSON a vista.
2. **Registro**: POST → Controlador valida → Modelo inserta → Redirect.

**Diagrama**:
```
Usuario → Controlador::searchByLegajo() → Modelo::getProfesorByLegajo() → JSON
```

## Beneficios y Comparación

Agrega búsquedas múltiples, custom methods. Muestra MVC para entidades con IDs únicos (legajo). Beneficios: flexibilidad en queries, separación clara.

## Conclusión

Profesores muestra MVC avanzado con búsquedas. Para explicar: "El modelo busca por legajo, controlador responde JSON, vista muestra resultados". Próximo: Estudiantes.
