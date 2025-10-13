# Flujo Completo y Didáctico de Registro de una Materia en CodeIgniter 4

## Introducción

Registro de materia con relaciones (categoria, modalidad, carrera). Muestra cómo MVC maneja entidades relacionadas.

## Paso 1: Acceso a Vista Materias

### Admin accede a "Materias".

### Controlador `Materias::index()`
- Carga materias, categorias, modalidades, carreras.

#### Código:
```php
public function index()
{
    $data['materias'] = $this->materiaModel->getMateriasWithRelations();
    $data['categorias'] = $this->db->table('Categoria')->get()->getResultArray();
    $data['modalidades'] = $this->db->table('Modalidad')->get()->getResultArray();
    $data['carreras'] = $this->db->table('Carrera')->get()->getResultArray();
    return view('administrador/materias', $data);
}
```

### Vista
- Form con nombre_materia, selects categoria, modalidad, carrera.
- Tabla con materias y joins.

## Paso 2: Ingreso Datos

- Nombre "Matemáticas", categoria "Básica", modalidad "Presencial", carrera "Ingeniería".

## Paso 3: POST a `materias/registrar`

### Controlador `Materias::registrar()`
- Recoge datos, save().

#### Código:
```php
public function registrar()
{
    $data = [
        'nombre_materia' => $this->request->getPost('nombre_materia'),
        'id_categoria' => $this->request->getPost('id_categoria'),
        'id_modalidad' => $this->request->getPost('id_modalidad'),
        'id_car' => $this->request->getPost('id_car'),
    ];
    if ($this->materiaModel->save($data)) {
        return redirect()->to('/administrador/materias')->with('success', 'Materia registrada.');
    } else {
        return redirect()->back()->withInput()->with('errors', $this->materiaModel->errors());
    }
}
```

## Paso 4: Modelo `MateriaModel`

- **Campos**: nombre_materia, id_categoria, id_modalidad, id_car.
- **Validaciones**: nombre required, unique, ids required.
- **save()**: Valida foreign keys implícitamente, inserta.

## Paso 5: Redirect y Actualización

- Tabla muestra nueva materia con nombres de relaciones via join.

## Diagrama

```
Form → POST → Controller → Model (validate FK + insert) → Redirect → Vista (join en tabla)
```

## Conclusión

Muestra relaciones en MVC. Modelo valida integridad referencial.
