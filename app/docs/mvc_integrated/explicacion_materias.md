# Explicación Didáctica del Patrón MVC en CodeIgniter 4: Gestión de Materias

## Introducción

En esta explicación, profundizamos en el patrón MVC de CodeIgniter 4 mediante el módulo de **Gestión de Materias**, que maneja asignaturas académicas vinculadas a carreras. Este ejemplo muestra cómo MVC maneja relaciones entre entidades (materias pertenecen a carreras), paginación y filtrado, haciendo la aplicación más compleja y realista.

Recuerda: MVC separa lógica en Modelo (datos), Vista (UI), Controlador (coordinación). En CI4, esto facilita escalabilidad y mantenimiento.

## Estructura del Módulo de Materias en MVC

### Vista: `app/Views/administrador/materias.php`

La vista es más avanzada: incluye selección de carrera para filtrar/agregar, paginación, y manejo de errores de BD.

#### Funcionalidades clave:
- **Selección de Carrera**: Dropdown para elegir carrera antes de registrar materia.
- **Registro**: Formulario con nombre y código, oculto hasta seleccionar carrera.
- **Búsqueda y Listado**: Tabla paginada con filtrado por carrera.
- **Edición**: Modal para actualizar nombre, código, carrera.
- **Paginación**: Usa Pager de CI4 para navegación.
- **Manejo de Errores**: Muestra alertas si BD falla.

#### Código relevante:
```php
// Selección de carrera
<select id="carreraSelect">
    <?php foreach ($carreras as $carrera): ?>
        <option value="<?= esc($carrera['id_car']) ?>"><?= esc($carrera['ncar']) ?></option>
    <?php endforeach; ?>
</select>

// Paginación
<?= $pager->links() ?>
```

**Lección didáctica**: La vista maneja UI compleja, pero no lógica de negocio. Datos vienen del controlador.

### Controlador: `app/Controllers/Materias.php`

El controlador introduce paginación y filtrado, mostrando cómo manejar queries avanzadas.

#### Métodos principales:
- **`index()`**: Carga materias con paginación (10 por página), filtra por carrera_id si presente. Maneja excepciones.
- **`registrar()`**: Inserta nueva materia con carrera_id.
- **`edit/update/delete/search`**: CRUD estándar.
- **`searchCarrera()`**: Busca carreras por nombre (para AJAX).

#### Código clave:
```php
public function index()
{
    $perPage = 10;
    $carreraId = $this->request->getVar('carrera_id');
    if ($carreraId) {
        $this->materiaModel->where('carrera_id', $carreraId);
    }
    $data['materias'] = $this->materiaModel->paginate($perPage);
    $data['pager'] = $this->materiaModel->pager;
    // ...
}
```

**Lección didáctica**: El controlador usa métodos de CI4 como `paginate()` para simplificar. Coordina múltiples modelos (Materia y Carrera).

### Modelo: `app/Models/MateriaModel.php`

El modelo valida relaciones: código único, carrera_id requerida.

#### Características:
- **Campos**: nombre_materia, codigo_materia, carrera_id.
- **Validación**: Código único, carrera_id entero.
- **Relaciones**: Vincula con CarreraModel vía carrera_id.

#### Código:
```php
protected $validationRules = [
    'codigo_materia' => 'required|min_length[2]|max_length[20]|is_unique[Materia.codigo_materia,id,{id}]',
    'carrera_id' => 'required|integer',
];
```

**Lección didáctica**: El modelo asegura integridad referencial. Cambios aquí afectan todas las operaciones.

## Flujo MVC en Materias

1. **Usuario filtra por carrera**: GET con carrera_id → `index()` filtra y pagina.
2. **Vista muestra lista paginada**.
3. **Usuario registra**: POST → `registrar()` valida e inserta.
4. **Redirección con mensaje**.

**Diagrama**:
```
Usuario → Controlador::index() → Modelo::paginate() → Vista (con pager)
```

## Beneficios y Comparación

Más complejo que Usuarios/Roles: agrega paginación, filtrado, relaciones. Muestra cómo MVC escala a features avanzadas. Beneficios: separación clara, reutilización (e.g., paginación en otros módulos).

## Conclusión

Materias ilustra MVC con relaciones y paginación. Para explicar: "El modelo valida relaciones, el controlador pagina, la vista muestra filtros". Próximo: Profesores para más variaciones.
