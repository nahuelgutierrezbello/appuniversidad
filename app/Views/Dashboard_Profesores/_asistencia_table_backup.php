<!-- Vista Parcial: Tabla de Asistencia Mensual Completa -->
<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2980b9;
        --success-color: #2ecc71;
        --danger-color: #e74c3c;
        --light-color: #f8f9fa;
        --border-color: #dee2e6;
        --weekend-color: #f8d7da;
    }

    .attendance-container-<?= $materia_id ?> {
        max-width: 100%;
        margin: 0 auto;
        background-color: white;
        border-radius: 6px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .attendance-container-<?= $materia_id ?> .controls {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
        background-color: #f8f9fa;
        padding: 12px;
        border-radius: 6px;
    }

    .attendance-container-<?= $materia_id ?> .control-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .attendance-container-<?= $materia_id ?> .control-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: #555;
    }

    .attendance-container-<?= $materia_id ?> select, .attendance-container-<?= $materia_id ?> button {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-size: 14px;
        background-color: white;
    }

    .attendance-container-<?= $materia_id ?> button {
        background-color: var(--primary-color);
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
        align-self: flex-end;
    }

    .attendance-container-<?= $materia_id ?> button:hover {
        background-color: var(--secondary-color);
    }

    .attendance-container-<?= $materia_id ?> .table-container {
        overflow-x: auto;
        margin-top: 15px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        max-height: 65vh;
        overflow-y: auto;
    }

    .attendance-container-<?= $materia_id ?> table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
        font-size: 13px;
    }

    .attendance-container-<?= $materia_id ?> th, .attendance-container-<?= $materia_id ?> td {
        padding: 8px 10px;
        text-align: center;
        border: 1px solid var(--border-color);
    }

    .attendance-container-<?= $materia_id ?> th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        position: sticky;
        top: 0;
    }

    .attendance-container-<?= $materia_id ?> th.person-header {
        background-color: var(--secondary-color);
        position: sticky;
        left: 0;
        z-index: 10;
        min-width: 120px;
    }

    .attendance-container-<?= $materia_id ?> td.person-name {
        background-color: #e9f7fe;
        font-weight: 600;
        position: sticky;
        left: 0;
        z-index: 5;
        min-width: 120px;
    }

    .attendance-container-<?= $materia_id ?> tr:nth-child(even) td.person-name {
        background-color: #d4edf9;
    }

    .attendance-container-<?= $materia_id ?> tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .attendance-container-<?= $materia_id ?> .day-header {
        font-size: 0.75em;
        padding: 6px 4px;
        min-width: 28px;
    }

    .attendance-container-<?= $materia_id ?> .weekend {
        background-color: var(--weekend-color);
    }

    .attendance-container-<?= $materia_id ?> .attendance-cell {
        padding: 2px;
        position: relative;
        min-width: 28px;
    }

    .attendance-container-<?= $materia_id ?> .checkbox-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .attendance-container-<?= $materia_id ?> .attendance-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .attendance-container-<?= $materia_id ?> .person-row:hover {
        background-color: #e9f7fe;
    }

    .attendance-container-<?= $materia_id ?> .percentage-cell {
        background-color: #f0f8ff;
        font-weight: bold;
        color: var(--primary-color);
        min-width: 60px;
    }

    .attendance-container-<?= $materia_id ?> .status-summary {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        padding: 12px;
        background-color: #f8f9fa;
        border-radius: 4px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .attendance-container-<?= $materia_id ?> .status-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
    }

    .attendance-container-<?= $materia_id ?> .status-color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .attendance-container-<?= $materia_id ?> .present {
        background-color: var(--success-color);
    }

    .attendance-container-<?= $materia_id ?> .absent {
        background-color: var(--danger-color);
    }

    .attendance-container-<?= $materia_id ?> .actions {
        display: flex;
        gap: 8px;
        margin-top: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .attendance-container-<?= $materia_id ?> .save-btn {
        background-color: var(--success-color);
    }

    .attendance-container-<?= $materia_id ?> .reset-btn {
        background-color: var(--danger-color);
    }

    .attendance-container-<?= $materia_id ?> .stats {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        padding: 12px;
        background-color: #e9f7fe;
        border-radius: 4px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .attendance-container-<?= $materia_id ?> .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .attendance-container-<?= $materia_id ?> .stat-value {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--primary-color);
    }

    .attendance-container-<?= $materia_id ?> .stat-label {
        font-size: 0.8rem;
        color: #666;
    }

    .attendance-container-<?= $materia_id ?> .day-info {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .attendance-container-<?= $materia_id ?> .day-number {
        font-weight: bold;
        font-size: 0.9em;
    }

    .attendance-container-<?= $materia_id ?> .day-name {
        font-size: 0.7em;
        opacity: 0.8;
    }

    .attendance-container-<?= $materia_id ?> .month-year-display {
        text-align: center;
        font-size: 1rem;
        font-weight: bold;
        margin: 8px 0;
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .attendance-container-<?= $materia_id ?> .controls {
            flex-direction: column;
            align-items: center;
        }

        .attendance-container-<?= $materia_id ?> .control-group {
            width: 100%;
            max-width: 250px;
        }

        .attendance-container-<?= $materia_id ?> select, .attendance-container-<?= $materia_id ?> button {
            width: 100%;
        }
    }
</style>

<div class="attendance-container-<?= $materia_id ?>" data-materia-id="<?= $materia_id ?>">
    <div class="controls">
        <div class="control-group">
            <span class="control-label">Mes</span>
            <select id="month-select-<?= $materia_id ?>">
                <option value="0">Enero</option>
                <option value="1">Febrero</option>
                <option value="2">Marzo</option>
                <option value="3">Abril</option>
                <option value="4">Mayo</option>
                <option value="5">Junio</option>
                <option value="6">Julio</option>
                <option value="7">Agosto</option>
                <option value="8">Septiembre</option>
                <option value="9">Octubre</option>
                <option value="10">Noviembre</option>
                <option value="11">Diciembre</option>
            </select>
        </div>

        <div class="control-group">
            <span class="control-label">Año</span>
            <select id="year-select-<?= $materia_id ?>">
                <!-- Los años se cargarán dinámicamente -->
            </select>
        </div>

        <div class="control-group">
            <span class="control-label">Acción</span>
            <button id="generate-btn-<?= $materia_id ?>">Mostrar Tabla</button>
        </div>
    </div>

    <div class="month-year-display" id="month-year-display-<?= $materia_id ?>">
        <!-- Se mostrará el mes y año seleccionado -->
    </div>

    <div class="table-container">
        <table id="attendance-table-<?= $materia_id ?>">
            <!-- La tabla se generará dinámicamente -->
        </table>
    </div>

    <div class="stats" id="stats-container-<?= $materia_id ?>">
        <!-- Las estadísticas se generarán dinámicamente -->
    </div>

    <div class="status-summary">
        <div class="status-item">
            <div class="status-color present"></div>
            <span>Presente</span>
        </div>
        <div class="status-item">
            <div class="status-color absent"></div>
            <span>Ausente</span>
        </div>
        <div class="status-item">
            <div class="status-color weekend"></div>
            <span>Fin de semana</span>
        </div>
    </div>

    <div class="actions">
        <button id="save-btn-<?= $materia_id ?>" class="save-btn">Guardar</button>
        <button id="reset-btn-<?= $materia_id ?>" class="reset-btn">Restablecer</button>
        <button id="mark-all-present-<?= $materia_id ?>" style="background-color: var(--success-color)">Todos Presentes</button>
        <button id="mark-all-absent-<?= $materia_id ?>" style="background-color: var(--danger-color)">Todos Ausentes</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeAttendanceTable(<?= $materia_id ?>);
});

function initializeAttendanceTable(materiaId) {
    // Elementos del DOM
    const monthSelect = document.getElementById(`month-select-${materiaId}`);
    const yearSelect = document.getElementById(`year-select-${materiaId}`);
    const generateBtn = document.getElementById(`generate-btn-${materiaId}`);
    const attendanceTable = document.getElementById(`attendance-table-${materiaId}`);
    const saveBtn = document.getElementById(`save-btn-${materiaId}`);
    const resetBtn = document.getElementById(`reset-btn-${materiaId}`);
    const markAllPresentBtn = document.getElementById(`mark-all-present-${materiaId}`);
    const markAllAbsentBtn = document.getElementById(`mark-all-absent-${materiaId}`);
    const monthYearDisplay = document.getElementById(`month-year-display-${materiaId}`);
    const statsContainer = document.getElementById(`stats-container-${materiaId}`);

    // Datos de ejemplo (estudiantes) - En producción, estos vendrían del servidor
    const students = [
        { id: 1, name: "Ana García" },
        { id: 2, name: "Carlos López" },
        { id: 3, name: "María Rodríguez" },
        { id: 4, name: "José Martínez" },
        { id: 5, name: "Laura Sánchez" },
        { id: 6, name: "Miguel Pérez" },
        { id: 7, name: "Elena Díaz" },
        { id: 8, name: "David Ruiz" }
    ];

    // Nombres de los días de la semana
    const dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

    // Nombres de los meses
    const monthNames = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];

    // Objeto para almacenar el estado de las asistencias
    let attendanceState = {};

    // Inicializar años en el selector (desde 2020 hasta 2030)
    function initializeYearSelect() {
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth();

        // Establecer el mes actual como seleccionado por defecto
        monthSelect.value = currentMonth;

        for (let year = 2020; year <= 2030; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            if (year === currentYear) {
                option.selected = true;
            }
            yearSelect.appendChild(option);
        }
    }

    // Obtener el número de días en un mes específico
    function getDaysInMonth(month, year) {
        return new Date(year, month + 1, 0).getDate();
    }

    // Obtener el día de la semana para un día específico
    function getDayOfWeek(month, year, day) {
        return new Date(year, month, day).getDay();
    }

    // Obtener clave única para almacenar el estado de asistencia
    function getAttendanceKey(personId, day, month, year) {
        return `${year}-${month}-${day}-${personId}`;
    }

    // Obtener el estado guardado de una asistencia
    function getSavedAttendance(personId, day, month, year) {
        const key = getAttendanceKey(personId, day, month, year);
        return attendanceState[key];
    }

    // Guardar el estado de una asistencia
    function saveAttendance(personId, day, month, year, isPresent) {
        const key = getAttendanceKey(personId, day, month, year);
        attendanceState[key] = isPresent;
    }

    // Calcular el porcentaje de asistencia para una persona
    function calculatePercentage(personId, daysInMonth, month, year) {
        let presentCount = 0;

        for (let day = 1; day <= daysInMonth; day++) {
            const isPresent = getSavedAttendance(personId, day, month, year);
            if (isPresent === true) {
                presentCount++;
            }
        }

        return ((presentCount / daysInMonth) * 100).toFixed(1);
    }

    // Generar la tabla de asistencias
    function generateAttendanceTable() {
        const month = parseInt(monthSelect.value);
        const year = parseInt(yearSelect.value);

        // Actualizar el display del mes y año
        monthYearDisplay.textContent = `${monthNames[month]} ${year}`;

        // Limpiar tabla existente
        attendanceTable.innerHTML = '';

        // Crear encabezado de la tabla
        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');

        // Celda para el encabezado de alumnos
        const personHeader = document.createElement('th');
        personHeader.textContent = 'Alumno';
        personHeader.className = 'person-header';
        headerRow.appendChild(personHeader);

        // Generar encabezados para cada día del mes
        const daysInMonth = getDaysInMonth(month, year);

        for (let day = 1; day <= daysInMonth; day++) {
            const dayHeader = document.createElement('th');
            dayHeader.className = 'day-header';

            // Crear contenedor de información del día
            const dayInfo = document.createElement('div');
            dayInfo.className = 'day-info';

            // Número del día
            const dayNumber = document.createElement('div');
            dayNumber.className = 'day-number';
            dayNumber.textContent = day;
            dayInfo.appendChild(dayNumber);

            // Nombre del día
            const dayName = document.createElement('div');
            dayName.className = 'day-name';
            const dayOfWeek = getDayOfWeek(month, year, day);
            dayName.textContent = dayNames[dayOfWeek];
            dayInfo.appendChild(dayName);

            dayHeader.appendChild(dayInfo);

            // Determinar si es fin de semana
            if (dayOfWeek === 0 || dayOfWeek === 6) {
                dayHeader.classList.add('weekend');
            }

            headerRow.appendChild(dayHeader);
        }

        // Agregar columna de porcentaje
        const percentageHeader = document.createElement('th');
        percentageHeader.textContent = '% Asist.';
        percentageHeader.style.backgroundColor = '#2980b9';
        percentageHeader.style.minWidth = '60px';
        headerRow.appendChild(percentageHeader);

        thead.appendChild(headerRow);
        attendanceTable.appendChild(thead);

        // Crear cuerpo de la tabla
        const tbody = document.createElement('tbody');

        // Generar filas para cada alumno
        students.forEach(student => {
            const row = document.createElement('tr');
            row.className = 'person-row';

            // Celda con el nombre del alumno
            const nameCell = document.createElement('td');
            nameCell.textContent = student.name;
            nameCell.className = 'person-name';
            row.appendChild(nameCell);

            // Generar celdas de asistencia para cada día
            for (let day = 1; day <= daysInMonth; day++) {
                const attendanceCell = document.createElement('td');
                attendanceCell.className = 'attendance-cell';

                // Determinar si es fin de semana
                const dayOfWeek = getDayOfWeek(month, year, day);
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    attendanceCell.classList.add('weekend');
                }

                const checkboxContainer = document.createElement('div');
                checkboxContainer.className = 'checkbox-container';

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'attendance-checkbox';
                checkbox.dataset.personId = student.id;
                checkbox.dataset.day = day;

                // Obtener estado guardado o usar false como predeterminado
                const savedState = getSavedAttendance(student.id, day, month, year);
                checkbox.checked = savedState === undefined ? false : savedState;

                // Agregar evento para guardar estado y actualizar estadísticas
                checkbox.addEventListener('change', function() {
                    saveAttendance(student.id, day, month, year, checkbox.checked);
                    updateStats();
                    updatePercentage(student.id, daysInMonth, month, year);
                });

                checkboxContainer.appendChild(checkbox);
                attendanceCell.appendChild(checkboxContainer);
                row.appendChild(attendanceCell);
            }

            // Celda de porcentaje para el alumno
            const percentageCell = document.createElement('td');
            percentageCell.className = 'percentage-cell';
            percentageCell.id = `percentage-${materiaId}-${student.id}`;
            percentageCell.textContent = '0%';
            row.appendChild(percentageCell);

            tbody.appendChild(row);
        });

        attendanceTable.appendChild(tbody);

        // Actualizar estadísticas y porcentajes
        updateStats();
        updateAllPercentages(daysInMonth, month, year);
    }

    // Actualizar el porcentaje de un alumno específico
    function updatePercentage(personId, daysInMonth, month, year) {
        const percentage = calculatePercentage(personId, daysInMonth, month, year);
        const percentageCell = document.getElementById(`percentage-${materiaId}-${personId}`);
        percentageCell.textContent = `${percentage}%`;

        // Color según el porcentaje
        if (percentage >= 90) {
            percentageCell.style.color = '#2ecc71';
        } else if (percentage >= 70) {
            percentageCell.style.color = '#f39c12';
        } else {
            percentageCell.style.color = '#e74c3c';
        }
    }

    // Actualizar todos los porcentajes
    function updateAllPercentages(daysInMonth, month, year) {
        students.forEach(student => {
            updatePercentage(student.id, daysInMonth, month, year);
        });
    }

    // Actualizar estadísticas
    function updateStats() {
        const month = parseInt(monthSelect.value);
        const year = parseInt(yearSelect.value);
        const daysInMonth = getDaysInMonth(month, year);
        const totalCheckboxes = students.length * daysInMonth;

        // Contar asistencias desde el estado guardado
        let presentCount = 0;
        let absentCount = 0;

        students.forEach(student => {
            for (let day = 1; day <= daysInMonth; day++) {
                const isPresent = getSavedAttendance(student.id, day, month, year);
                if (isPresent === true) {
                    presentCount++;
                } else {
                    absentCount++;
                }
            }
        });

        // Calcular porcentajes
        const presentPercentage = ((presentCount / totalCheckboxes) * 100).toFixed(1);
        const absentPercentage = ((absentCount / totalCheckboxes) * 100).toFixed(1);

        // Actualizar estadísticas en el DOM
        statsContainer.innerHTML = `
            <div class="stat-item">
                <div class="stat-value">${presentCount}</div>
                <div class="stat-label">Días Presentes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">${absentCount}</div>
                <div class="stat-label">Días Ausentes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">${presentPercentage}%</div>
                <div class="stat-label">Asistencia General</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">${students.length}</div>
                <div class="stat-label">Total Alumnos</div>
            </div>
        `;
    }

    // Guardar asistencias con SweetAlert
    async function saveAttendances() {
        const result = await Swal.fire({
            title: '¿Guardar asistencias?',
            text: '¿Está seguro que desea guardar todas las asistencias?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#2ecc71',
            cancelButtonColor: '#e74c3c'
        });

        if (result.isConfirmed) {
            // En una aplicación real, aquí enviaríamos los datos al servidor
            console.log('Asistencias guardadas:', attendanceState);

            await Swal.fire({
                title: '¡Guardado!',
                text: 'Las asistencias se han guardado correctamente.',
                icon: 'success',
                confirmButtonColor: '#2ecc71'
            });
        }
    }

    // Restablecer asistencias con SweetAlert
    async function resetAttendances() {
        const result = await Swal.fire({
            title: '¿Restablecer asistencias?',
            text: '¿Está seguro que desea restablecer todas las asistencias? Se perderán todos los cambios.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, restablecer',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#3498db'
        });

        if (result.isConfirmed) {
            const month = parseInt(monthSelect.value);
            const year = parseInt(yearSelect.value);
            const daysInMonth = getDaysInMonth(month, year);

            // Eliminar todas las asistencias del mes actual
            students.forEach(student => {
                for (let day = 1; day <= daysInMonth; day++) {
                    const key = getAttendanceKey(student.id, day, month, year);
                    delete attendanceState[key];
                }
            });

            // Regenerar la tabla
            generateAttendanceTable();

            await Swal.fire({
                title: '¡Restablecido!',
                text: 'Todas las asistencias han sido restablecidas.',
                icon: 'success',
                confirmButtonColor: '#2ecc71'
            });
        }
    }

    // Marcar todos como presentes con SweetAlert
    async function markAllPresent() {
        const result = await Swal.fire({
            title: '¿Marcar todos como presentes?',
            text: '¿Está seguro que desea marcar a todos los alumnos como presentes en todos los días?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, marcar todos',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#2ecc71',
            cancelButtonColor: '#e74c3c'
        });

        if (result.isConfirmed) {
            const month = parseInt(monthSelect.value);
            const year = parseInt(yearSelect.value);
            const daysInMonth = getDaysInMonth(month, year);

            students.forEach(student => {
                for (let day = 1; day <= daysInMonth; day++) {
                    saveAttendance(student.id, day, month, year, true);
                }
            });

            // Regenerar la tabla
            generateAttendanceTable();

            await Swal.fire({
                title: '¡Completado!',
                text: 'Todos los alumnos han sido marcados como presentes.',
                icon: 'success',
                confirmButtonColor: '#2ecc71'
            });
        }
    }

    // Marcar todos como ausentes con SweetAlert
    async function markAllAbsent() {
        const result = await Swal.fire({
            title: '¿Marcar todos como ausentes?',
            text: '¿Está seguro que desea marcar a todos los alumnos como ausentes en todos los días?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, marcar todos',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#3498db'
        });

        if (result.isConfirmed) {
            const month = parseInt(monthSelect.value);
            const year = parseInt(yearSelect.value);
            const daysInMonth = getDaysInMonth(month, year);

            students.forEach(student => {
                for (let day = 1; day <= daysInMonth; day++) {
                    saveAttendance(student.id, day, month, year, false);
                }
            });

            // Regenerar la tabla
            generateAttendanceTable();

            await Swal.fire({
                title: '¡Completado!',
                text: 'Todos los alumnos han sido marcados como ausentes.',
                icon: 'success',
                confirmButtonColor: '#2ecc71'
            });
        }
    }

    // Event listeners para los 4 botones con SweetAlert
    saveBtn.addEventListener('click', saveAttendances);
    resetBtn.addEventListener('click', resetAttendances);
    markAllPresentBtn.addEventListener('click', markAllPresent);
    markAllAbsentBtn.addEventListener('click', markAllAbsent);

    // Event listener para mostrar tabla (sin SweetAlert)
    generateBtn.addEventListener('click', generateAttendanceTable);

    // Inicializar la aplicación
    initializeYearSelect();
    generateAttendanceTable();
}
</script>
