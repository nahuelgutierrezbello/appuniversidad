# Flujo Completo y Didáctico de Registro de una Categoría en CodeIgniter 4

## Introducción

Registro de categoría con nombre y código único. Muestra validación de unicidad.

## Paso 1: Acceso a Vista Categorias

### Admin a "Categorias".

### Controlador `Categorias::index()`
- Carga categorias.

#### Código:
```php
public function index()
{
    $model = new CategoriaModel();
    $data['categorias'] = $model->findAll();
    return view('administrador/categorias', $data);
}
```

## Paso 2: Ingreso Datos

- Nombre "Ciencias Básicas", Código "CB01".

## Paso 3: POST a `categorias/registrar`

### Controlador `Categorias::registrar()`
- Recoge ncat, codcat, save().

#### Código:
```php
public function registrar()
{
    $model = new CategoriaModel();
    $data = [
        'ncat' => $this->request->getPost('ncat'),
        'codcat' => $this->request->getPost('codcat')
    ];
    if ($model->save($data) === false) {
        return redirect()->to('/categorias')->withInput()->with('errors', 'Error al registrar: ' . implode(', ', $model->errors()));
    }
    return redirect()->to('/categorias')->with('success', 'Categoría registrada correctamente.');
}
```

## Paso 4: Modelo `CategoriaModel`

- **Campos**: ncat, codcat.
- **Validaciones**: ncat required, codcat required, unique.
- **save()**: Valida, inserta.

#### Código:
```php
protected $validationRules = [
    'codcat' => 'required|is_unique[Categoria.codcat,id_cat,{id_cat}]|max_length[20]',
    'ncat'   => 'required|min_length[2]|max_length[120]',
];
```

## Paso 5: Redirect

- Tabla actualizada.

## Conclusión

Muestra validación de unicidad en BD.
