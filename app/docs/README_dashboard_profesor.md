# 📖 Guía Técnica: Funcionamiento del Dashboard del Profesor

## 1. Objetivo Principal

El objetivo es que, en el panel del profesor, al hacer clic en una materia, se despliegue un acordeón con dos pestañas:

1.  **Asistencias (activa por defecto)**: Muestra una vista de calendario mensual para la gestión de asistencias.
2.  **Notas**: Muestra una lista de los estudiantes inscritos para cargar o ver sus calificaciones.

Comprendo que los cambios anteriores en el código no reflejaban esto visualmente de inmediato. La siguiente explicación aclara por qué esos pasos eran necesarios y cómo conducen al resultado final que esperas.

---

## 2. La Arquitectura MVC: ¿Por qué los cambios "invisibles"?

La aplicación usa el patrón **Modelo-Vista-Controlador (MVC)**. Esto significa que la lógica está separada en tres capas:

- **Modelo**: Habla con la base de datos.
- **Controlador**: Organiza los datos que pide al Modelo.
- **Vista**: Muestra los datos que le entrega el Controlador.

Para que la **Vista** (lo que tú ves) funcione, primero el **Controlador** y el **Modelo** deben prepararle los datos. Los cambios anteriores se centraron en estos dos puntos.

---

## 3. Explicación de los Cambios Realizados (Paso a Paso)

### Paso 1: El Modelo (`ProfesorModel.php`) - La Fuente de Datos

**¿Qué se hizo?**
Se añadió el método `getDetalleAsistenciaPorMateria($materia_id)`.

**¿Por qué era necesario?**
Antes de este cambio, no existía una forma de pedirle a la base de datos: "Dame todas las asistencias de esta materia, agrupadas por día y mes". Este método es la consulta SQL que trae los datos exactos que el calendario de `ver.html` necesita para dibujarse.

> **En resumen: Sin este método, el calendario de asistencias estaría siempre vacío porque no tendría datos que mostrar.**

---

### Paso 2: El Controlador (`Profesores.php`) - El Organizador

**¿Qué se hizo?**
Se modificó el método `carreras()`.

**¿Por qué era necesario?**
Este método ahora actúa como un "centro de operaciones". Antes de mostrar la página, hace todo esto en segundo plano:

1.  Obtiene la lista de **materias** del profesor.
2.  Para **cada materia**, pide al Modelo:
    -   La lista de **estudiantes** inscritos.
    -   Las **notas** de esos estudiantes.
    -   Las **asistencias** (usando el nuevo método del Paso 1).
3.  Organiza toda esta información en arrays (`$estudiantes_por_materia`, `$notas_por_materia`, etc.).
4.  Finalmente, entrega todo este paquete de datos bien organizado a la **Vista**.

> **En resumen: Este paso es el puente invisible. Prepara y ordena toda la información para que la Vista solo tenga que preocuparse de mostrarla, sin hacer cálculos ni consultas complejas.**

---

### Paso 3: La Vista (`carreras.php`) - El Resultado Visual

**¿Qué se hizo?**
Se reestructuró completamente el archivo para crear el acordeón y las pestañas que pediste.

**¿Cómo funciona ahora?**

1.  **Acordeón**: El código recorre cada materia que el Controlador le pasó y crea un item de acordeón.

    ```php
    <?php foreach ($materias as $materia): ?>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button">
                    <?= esc($materia['nombre_materia']) ?>
                </button>
            </h2>
            <div class="accordion-collapse collapse">
                <div class="accordion-body">
                    <!-- Aquí dentro van las pestañas -->
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    ```

2.  **Pestañas (Solapas)**: Dentro del cuerpo del acordeón, se crea la estructura de pestañas. **La clave está en la clase `active`**, que se asigna a la pestaña "Asistencias" para que sea la primera que veas.

    ```php
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <!-- La clase "active" hace que esta pestaña se muestre primero -->
            <button class="nav-link active" id="asistencia-tab-..." data-bs-toggle="tab" data-bs-target="#asistencia-...">
                Asistencias
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="notas-tab-..." data-bs-toggle="tab" data-bs-target="#notas-...">
                Notas
            </button>
        </li>
    </ul>
    ```

3.  **Contenido de las Pestañas**:
    -   En la pestaña de **Asistencias**, se incluye la vista del calendario (`_asistencia_calendario.php`), que es la representación de tu `ver.html`. Se le pasan los datos de asistencia que el Controlador ya preparó.
    -   En la pestaña de **Notas**, se muestra la tabla con la lista de estudiantes y sus campos para notas.

## 4. Conclusión

El flujo que pediste está implementado exactamente así: **Materia -> abre el acordeón -> aparece la pestaña "Asistencias" (con el calendario) por defecto -> al lado, está la pestaña "Notas"**.

Los cambios en el Modelo y el Controlador fueron los cimientos indispensables para poder construir esta funcionalidad en la Vista de manera correcta y ordenada. Espero que esta explicación aclare por qué eran necesarios y cómo contribuyen al resultado final que ahora deberías ver en pantalla.