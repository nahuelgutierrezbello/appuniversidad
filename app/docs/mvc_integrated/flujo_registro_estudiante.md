# Flujo Completo y Didáctico de Registro de un Estudiante en CodeIgniter 4

## Introducción

Este documento explica paso a paso, de manera completa y didáctica, cómo funciona el registro de un estudiante en la aplicación. Desde que el administrador abre la vista, ingresa datos, hasta que se guarda en la BD y se actualiza la tabla en la vista. Muestra el patrón MVC en acción, con rutas, validaciones, redirecciones y AJAX si aplica.

Recuerda: MVC separa responsabilidades: Vista (UI), Controlador (lógica), Modelo (datos).

## Paso 1: Acceso a la Vista de Estudiantes

### Usuario (Administrador)
- El admin está logueado y accede al panel admin.
- Navega a "Estudiantes" en el menú (e.g., via navbar admin).

### Ruta y Controlador
- **Ruta**: `/administrador/estudiantes` (definida en `Routes.php`).
- **Controlador**: `Estudiantes::index()`.
- **Acción**: Carga datos de estudiantes y carreras.

#### Código en `Estudiantes.php`:
```php
public function index()
{
    $data['estudiantes'] = $this->estudianteModel->findAll();
    $data['carreras'] = $this->db->table('Carrera')->get()->getResultArray();
    return view('administrador/estudiantes', $data);
}
```

**Lección**: El controlador prepara datos (estudiantes para tabla, carreras para dropdown) y pasa a vista.

### Vista Renderizada
- **Archivo**: `app/Views/administrador/estudiantes.php`.
- **Elementos**: Formulario de registro con campos (nombre, DNI, edad, email, fecha_nac, carrera), tabla con lista de estudiantes.
- **Datos Dinámicos**: `<?php foreach($estudiantes as $est): ?>` para tabla, `<?php foreach($carreras as $car): ?>` para select.

**Lección**: Vista recibe array de datos del controlador y los muestra.

## Paso 2: Ingreso de Datos en el Formulario

### Usuario
- Admin llena el form: nombre "Juan Pérez", DNI "12345678", edad "20", email "juan@email.com", fecha_nac "2003-01-01", carrera "Ingeniería".
- Click en "Registrar Estudiante".

### Formulario HTML
```html
<form id="studentForm" method="post" action="<?= base_url('estudiantes/registrar') ?>">
    <?= csrf_field() ?>
    <input type="text" name="nest" required />
    <input type="text" name="dni" pattern="\d{8}" required />
    <!-- ... otros campos -->
    <button type="submit">Registrar Estudiante</button>
</form>
```

**Lección**: Form POST a `estudiantes/registrar`, incluye CSRF para seguridad.

## Paso 3: Envío y Procesamiento en el Controlador

### Petición HTTP
- **Método**: POST.
- **URL**: `base_url('estudiantes/registrar')`.
- **Datos**: nest=Juan Pérez, dni=12345678, etc.

### Controlador: `Estudiantes::registrar()`
El controlador actúa como intermediario: recibe input del usuario, lo prepara para el modelo, y decide el flujo basado en resultado. No maneja BD ni validaciones directamente.

#### Explicación paso a paso del código:
```php
public function registrar()
{
    // Recoge cada campo del form usando request->getPost().
    // getPost() es seguro: sanitiza input, previene XSS básico.
    $data = [
        'nest' => $this->request->getPost('nest'),        // Nombre estudiante
        'dni' => $this->request->getPost('dni'),          // DNI único
        'edad' => $this->request->getPost('edad'),        // Edad numérica
        'email' => $this->request->getPost('email'),      // Email válido
        'fecha_nac' => $this->request->getPost('fecha_nac'), // Fecha nacimiento
        'id_car' => $this->request->getPost('id_car'),    // ID carrera seleccionada
    ];

    // Llama save() del modelo. Este valida según reglas, inserta si ok.
    if ($this->estudianteModel->save($data)) {
        // Éxito: save() true, datos insertados.
        // Redirect a lista estudiantes, pasa mensaje éxito en session.
        return redirect()->to('/administrador/estudiantes')->with('success', 'Estudiante registrado exitosamente.');
    } else {
        // Error: save() false, errors() tiene array mensajes.
        // Redirect back al form, mantiene input, pasa errores.
        return redirect()->back()->withInput()->with('errors', $this->estudianteModel->errors());
    }
}
```

**¿Por qué es didáctico?** Controlador separa lógica: input → modelo → resultado. `withInput()` mejora UX. `with('errors')` permite alertas. Flash messages usan session.

## Paso 4: Validación y Guardado en el Modelo

### Modelo: `EstudianteModel`
- **Campos Permitidos**: nest, dni, edad, email, fecha_nac, id_car.
- **Validaciones**:
  - dni: required, exact_length[8], is_unique[Estudiante.dni,id_est,{id_est}].
  - email: required, valid_email.
  - edad: integer, etc.
- **Método save()**: Ejecuta validaciones, si pasan, inserta en tabla 'Estudiante'.

#### Código:
```php
protected $validationRules = [
    'dni' => 'required|exact_length[8]|is_unique[Estudiante.dni,id_est,{id_est}]',
    'email' => 'required|valid_email',
    // ...
];
```

**Lección**: Modelo asegura integridad (DNI único, email válido), previene datos malos.

### Base de Datos
- **Tabla**: 'Estudiante'.
- **Insert**: Nuevo registro con id_est auto-increment, datos del array.
- **Resultado**: Estudiante guardado, o error si validación falla.

**Lección**: Modelo interactúa directamente con BD via CI4 ORM.

## Paso 5: Redirección y Actualización de la Vista

### Después de Guardado Exitoso
- **Redirect**: A `/administrador/estudiantes`.
- **Flash Message**: 'Estudiante registrado exitosamente.' en session.

### Controlador `index()` de Nuevo
- Carga estudiantes actualizados (incluye el nuevo).
- Pasa a vista.

### Vista Actualizada
- **Tabla**: Ahora incluye el nuevo estudiante.
- **Mensaje**: Muestra success alert.
- **Código**: `<?php if (session()->has('success')): ?> <div class="alert alert-success"> <?= session('success') ?> </div>`

**Lección**: Redirect recarga vista con datos frescos, flash muestra feedback.

## Flujo Completo en Diagrama

```
Usuario → Vista (form) → POST /estudiantes/registrar → Controlador::registrar()
    ↓
Modelo::save() → Validaciones → Insert BD
    ↓
Success: Redirect /administrador/estudiantes → Controlador::index() → Vista (tabla actualizada + mensaje)
Error: Redirect back → Vista (form con errores)
```

## Beneficios del Flujo

- **Separación**: Vista no toca BD, controlador no renderiza HTML.
- **Validación**: Doble (client-side en form, server-side en modelo).
- **Feedback**: Mensajes claros para usuario.
- **Seguridad**: CSRF, validaciones evitan inyección.

## Conclusión

El registro sigue MVC: vista captura input, controlador coordina, modelo guarda. Para explicar: "Admin llena form, POST a controller, valida y guarda en BD, redirect actualiza tabla". Este flujo aplica a otras entidades con ajustes.
