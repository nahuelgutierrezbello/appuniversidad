# Explicación Completa y Didáctica del Dashboard del Estudiante

## Introducción

El dashboard del estudiante en esta aplicación web está diseñado para mostrar información personalizada de manera automática, ejecutando consultas SQL en segundo plano sin intervención del usuario. Este documento explica de forma detallada y didáctica cómo funciona este proceso, desde la arquitectura hasta la implementación específica.

## Arquitectura General: Patrón MVC

La aplicación sigue el patrón de diseño **Modelo-Vista-Controlador (MVC)**, que separa las responsabilidades:

- **Modelo (Model)**: Maneja la lógica de datos y las consultas a la base de datos.
- **Vista (View)**: Presenta la información al usuario.
- **Controlador (Controller)**: Coordina entre el modelo y la vista, procesando las solicitudes.

En el caso del dashboard del estudiante, el flujo es el siguiente:

1. El usuario accede a la URL del dashboard.
2. El controlador recibe la solicitud.
3. El controlador consulta al modelo para obtener datos.
4. El modelo ejecuta consultas SQL y devuelve los resultados.
5. El controlador pasa los datos a la vista.
6. La vista renderiza la página con los datos.

## Controlador: Estudiantes.php

El controlador `Estudiantes.php` es el "director de orquesta" para todo lo relacionado con estudiantes. El método clave es `dashboard()`.

### Código del Método dashboard()

```php
public function dashboard()
{
    // Por ahora, usar estudiante con ID 1. En el futuro, usar sesión.
    $id_est = 1;

    $estudianteModel = new EstudianteModel();
    $materiaModel = new MateriaModel();

    $data['estudiante'] = $estudianteModel->getEstudianteConCarrera($id_est);
    $data['notas'] = $estudianteModel->getNotas($id_est);
    $data['materias_inscritas'] = $estudianteModel->getMateriasInscritas($id_est);
    $data['estadisticas'] = $estudianteModel->getEstadisticas($id_est);

    // Materiales por materia (para el accordion)
    $materiales_por_materia = [];
    foreach ($data['materias_inscritas'] as $inscripcion) {
        $materiales_por_materia[$inscripcion['materia_id']] = $materiaModel->getMateriales($inscripcion['materia_id']);
    }
    $data['materiales_por_materia'] = $materiales_por_materia;

    return view('dashboard_estudiante', $data);
}
```

### Explicación Paso a Paso

1. **Identificación del Estudiante**: Actualmente usa un ID fijo (1). En producción, se usaría la sesión del usuario logueado.

2. **Instanciación de Modelos**: Crea instancias de `EstudianteModel` y `MateriaModel` para acceder a los datos.

3. **Obtención de Datos**:
   - `getEstudianteConCarrera($id_est)`: Obtiene información básica del estudiante y su carrera.
   - `getNotas($id_est)`: Recupera todas las notas del estudiante.
   - `getMateriasInscritas($id_est)`: Lista las materias en las que está inscrito.
   - `getEstadisticas($id_est)`: Calcula estadísticas basadas en las notas y inscripciones.

4. **Materiales de Estudio**: Para cada materia inscrita, obtiene los materiales disponibles usando `MateriaModel::getMateriales()`.

5. **Renderizado de Vista**: Pasa todos los datos a la vista `dashboard_estudiante.php` y la devuelve.

## Modelo: EstudianteModel.php

El modelo `EstudianteModel` extiende la clase base `Model` de CodeIgniter y define métodos personalizados para consultas específicas.

### Métodos Clave y Sus Consultas SQL

#### 1. getEstudianteConCarrera($id)

```php
public function getEstudianteConCarrera($id)
{
    return $this->select('Estudiante.*, Carrera.nombre_carrera')
        ->join('Carrera', 'Carrera.id = Estudiante.carrera_id', 'left')
        ->find($id);
}
```

**Consulta SQL generada**:
```sql
SELECT Estudiante.*, Carrera.nombre_carrera
FROM Estudiante
LEFT JOIN Carrera ON Carrera.id = Estudiante.carrera_id
WHERE Estudiante.id = ?
```

Esta consulta obtiene todos los campos del estudiante y el nombre de su carrera.

#### 2. getNotas($id_est)

```php
public function getNotas($id_est)
{
    return $this->db->table('Nota')
        ->select('Nota.*, Materia.nombre_materia')
        ->join('Materia', 'Materia.id = Nota.materia_id')
        ->where('Nota.estudiante_id', $id_est)
        ->get()
        ->getResultArray();
}
```

**Consulta SQL**:
```sql
SELECT Nota.*, Materia.nombre_materia
FROM Nota
JOIN Materia ON Materia.id = Nota.materia_id
WHERE Nota.estudiante_id = ?
```

Obtiene todas las notas del estudiante, incluyendo el nombre de la materia.

#### 3. getMateriasInscritas($id_est)

```php
public function getMateriasInscritas($id_est)
{
    return $this->db->table('Inscripcion')
        ->select('Inscripcion.*, Materia.nombre_materia, Materia.codigo_materia, Materia.id as materia_id')
        ->join('Materia', 'Materia.id = Inscripcion.materia_id')
        ->where('Inscripcion.estudiante_id', $id_est)
        ->get()
        ->getResultArray();
}
```

**Consulta SQL**:
```sql
SELECT Inscripcion.*, Materia.nombre_materia, Materia.codigo_materia, Materia.id as materia_id
FROM Inscripcion
JOIN Materia ON Materia.id = Inscripcion.materia_id
WHERE Inscripcion.estudiante_id = ?
```

Lista las inscripciones del estudiante con detalles de las materias.

#### 4. getEstadisticas($id_est)

Este método no ejecuta una consulta SQL directa, sino que procesa los datos obtenidos de `getNotas()` y `getMateriasInscritas()`.

```php
public function getEstadisticas($id_est)
{
    $notas = $this->getNotas($id_est);
    $totalNotas = count($notas);
    $sumaNotas = 0;
    foreach ($notas as $nota) {
        $sumaNotas += $nota['calificacion'];
    }
    $promedio = $totalNotas > 0 ? round($sumaNotas / $totalNotas, 2) : 0;

    $aprobadas = 0;
    foreach ($notas as $nota) {
        if ($nota['calificacion'] >= 6) {
            $aprobadas++;
        }
    }

    $inscritas = $this->getMateriasInscritas($id_est);
    $totalInscritas = count($inscritas);

    $progreso = $totalInscritas > 0 ? round(($aprobadas / $totalInscritas) * 100, 2) : 0;

    return [
        'promedio_general' => $promedio,
        'materias_aprobadas' => $aprobadas,
        'materias_pendientes' => $totalInscritas - $aprobadas,
        'progreso' => $progreso
    ];
}
```

Calcula estadísticas como promedio, materias aprobadas, etc.

## Modelo: MateriaModel.php

Para los materiales de estudio, se usa `MateriaModel::getMateriales($materia_id)`.

```php
// Asumiendo que existe este método en MateriaModel
public function getMateriales($materia_id)
{
    return $this->db->table('Material')
        ->where('materia_id', $materia_id)
        ->get()
        ->getResultArray();
}
```

**Consulta SQL**:
```sql
SELECT * FROM Material WHERE materia_id = ?
```

## Vista: dashboard_estudiante.php

La vista es un archivo HTML con PHP embebido que recibe los datos del controlador y los muestra.

### Estructura General

- **Perfil del Estudiante**: Muestra datos básicos usando `$estudiante`.
- **Notas**: Tabla con datos de `$notas`.
- **Materias Inscritas**: Cards con datos de `$materias_inscritas`.
- **Estadísticas**: Métricas calculadas en `$estadisticas`.
- **Materiales de Estudio**: Accordion con datos de `$materiales_por_materia`.

### Ejemplo de Renderizado

Para las notas:
```php
<?php if (!empty($notas)): ?>
    <?php foreach ($notas as $nota): ?>
        <tr>
            <td><?= esc($nota['nombre_materia']) ?></td>
            <td><?= esc($nota['calificacion']) ?></td>
            <td><?= esc($nota['fecha_evaluacion']) ?></td>
            <td><?= esc($nota['observaciones'] ?? 'Sin observaciones') ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="text-center">No hay notas disponibles.</td>
    </tr>
<?php endif; ?>
```

## Flujo Completo de Ejecución

1. **Solicitud HTTP**: Usuario accede a `/estudiantes/dashboard` (asumiendo la ruta configurada).

2. **Enrutamiento**: CodeIgniter dirige la solicitud al método `dashboard()` del controlador `Estudiantes`.

3. **Ejecución del Controlador**:
   - Instancia modelos.
   - Llama a métodos del modelo para obtener datos.
   - Prepara array `$data`.

4. **Consultas SQL**: Los modelos ejecutan las consultas automáticamente usando el Query Builder de CodeIgniter.

5. **Procesamiento de Datos**: Se calculan estadísticas y se organizan materiales.

6. **Renderizado**: La vista recibe `$data` y genera HTML dinámico.

7. **Respuesta**: Se envía la página completa al navegador del usuario.

## Seguridad y Mejores Prácticas

- **Validación**: Los modelos incluyen reglas de validación para prevenir inyección SQL.
- **Escaping**: En la vista, se usa `esc()` para prevenir XSS.
- **Sesiones**: En producción, usar ID de estudiante de la sesión, no hardcodeado.
- **Optimización**: Las consultas usan JOINs eficientes y se ejecutan solo cuando es necesario.

## Conclusión

El dashboard del estudiante demuestra una implementación completa del patrón MVC, donde las consultas SQL se ejecutan automáticamente en el backend y los resultados se presentan de forma clara y organizada en el frontend. Este enfoque permite una separación clara de responsabilidades, facilitando el mantenimiento y la escalabilidad del código.

La automatización se logra mediante:
- Controlador que coordina las operaciones.
- Modelos que encapsulan la lógica de datos y consultas.
- Vista que presenta la información de manera amigable.

Este sistema está listo para producción con mínimas modificaciones, como integrar autenticación de usuarios.
