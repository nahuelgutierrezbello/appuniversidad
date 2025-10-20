# Plan para Modificar Dashboard de Profesores

## Objetivo
Modificar el dashboard del profesor para que al expandir una materia, se muestre directamente la tabla de control de asistencias mensual con mes, días, porcentaje, alumnos y checkboxes, en lugar del texto descriptivo actual.

## Pasos a Realizar

### 1. Modificar app/Views/Dashboard_Profesores/dashboard_profesor.php
- Reemplazar el contenido descriptivo dentro del accordion de cada materia con la estructura de la tabla de asistencia mensual.
- Incluir selectores de mes y año.
- Incluir la tabla con estudiantes, días del mes, checkboxes y porcentajes.
- Incluir estadísticas (días presentes, ausentes, porcentaje general, total estudiantes).
- Incluir botones de acción (Guardar, Restablecer, Todos Presentes, Todos Ausentes).

### 2. Agregar JavaScript en dashboard_profesor.php
- Copiar y adaptar el JavaScript de control_asistencias.php para manejar la carga y guardado de asistencias.
- Modificar para que se active al expandir el accordion de la materia.
- Usar el ID de la materia para cargar datos específicos.

### 3. Verificar Controlador Profesores.php
- Asegurarse de que los métodos getDatosAsistenciaMensual y guardarAsistenciasMensuales estén disponibles y funcionen correctamente.

### 4. Incluir Estilos Necesarios
- Asegurarse de que los estilos de asistencia estén incluidos (public/styles_asistencia.css ya está en las pestañas abiertas).

### 5. Pruebas
- Probar que al expandir una materia, se cargue la tabla correctamente.
- Verificar que los checkboxes funcionen y se guarden los cambios.
- Confirmar que las estadísticas se actualicen en tiempo real.

## Dependencias
- app/Controllers/Profesores.php (métodos getDatosAsistenciaMensual, guardarAsistenciasMensuales)
- app/Models/AsistenciaModel.php
- public/styles_asistencia.css
- Librerías: SweetAlert2, Bootstrap

## Notas
- Mantener la funcionalidad existente del dashboard.
- Asegurar que la tabla se cargue con el mes y año actuales por defecto.
- Si no hay datos, mostrar mensaje apropiado.
