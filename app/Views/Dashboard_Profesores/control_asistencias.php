<?= $this->extend('Dashboard_Profesores/layout_profesor') ?>

<?= $this->section('title') ?>
    Control de Asistencias - <?= esc($materia['nombre_materia']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-muted mb-0 small">Gestión de Asistencias</p>
                <h2 class="mb-0">Control de Asistencias Mensual</h2>
                <p class="text-muted mt-1">Materia: <?= esc($materia['nombre_materia']) ?> - Código: <?= esc($materia['codigo_materia']) ?></p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary" onclick="window.history.back()">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                </button>
            </div>
        </div>

        <!-- Controles de Mes y Año -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="month-select" class="form-label fw-bold">Mes</label>
                        <select id="month-select" class="form-select">
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
                    <div class="col-md-3">
                        <label for="year-select" class="form-label fw-bold">Año</label>
                        <select id="year-select" class="form-select">
                            <!-- Los años se cargarán dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button id="generate-btn" class="btn btn-primary w-100">
                            <i class="fas fa-table me-2"></i>Mostrar Tabla
                        </button>
                    </div>
                    <div class="col-md-3">
                        <div id="month-year-display" class="text-center fw-bold text-primary fs-5">
                            <!-- Se mostrará el mes y año seleccionado -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Asistencias -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="attendance-table" class="table table-striped table-hover">
                        <!-- La tabla se generará dinámicamente -->
                    </table>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="row mt-4" id="stats-container">
            <!-- Las estadísticas se cargarán dinámicamente -->
        </div>

        <!-- Botones de Acción -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <button id="save-btn" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Guardar Asistencias
                    </button>
                    <button id="reset-btn" class="btn btn-warning">
                        <i class="fas fa-undo me-2"></i>Restablecer
                    </button>
                    <button id="mark-all-present" class="btn btn-info">
                        <i class="fas fa-check-circle me-2"></i>Todos Presentes
                    </button>
                    <button id="mark-all-absent" class="btn btn-danger">
                        <i class="fas fa-times-circle me-2"></i>Todos Ausentes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalTitle">Confirmar Acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="confirmationModalBody">
                ¿Está seguro de realizar esta acción?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const materiaId = <?= $materia['id'] ?>;
    let attendanceData = {};
    let currentMonth, currentYear;

    // Elementos del DOM
    const monthSelect = document.getElementById('month-select');
    const yearSelect = document.getElementById('year-select');
    const generateBtn = document.getElementById('generate-btn');
    const attendanceTable = document.getElementById('attendance-table');
    const saveBtn = document.getElementById('save-btn');
    const resetBtn = document.getElementById('reset-btn');
    const markAllPresentBtn = document.getElementById('mark-all-present');
    const markAllAbsentBtn = document.getElementById('mark-all-absent');
    const monthYearDisplay = document.getElementById('month-year-display');
    const statsContainer = document.getElementById('stats-container');

    // Inicializar selectores
    initializeSelectors();

    // Event listeners
    generateBtn.addEventListener('click', loadAttendanceTable);
    saveBtn.addEventListener('click', saveAttendances);
    resetBtn.addEventListener('click', resetAttendances);
    markAllPresentBtn.addEventListener('click', markAllPresent);
    markAllAbsentBtn.addEventListener('click', markAllAbsent);

    function initializeSelectors() {
        const now = new Date();
        currentMonth = now.getMonth();
        currentYear = now.getFullYear();

        monthSelect.value = currentMonth;

        // Llenar años
        for (let year = currentYear - 2; year <= currentYear + 2; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            if (year === currentYear) option.selected = true;
            yearSelect.appendChild(option);
        }
    }

    function loadAttendanceTable() {
        currentMonth = parseInt(monthSelect.value);
        currentYear = parseInt(yearSelect.value);

        fetch(`<?= base_url('profesores/getDatosAsistenciaMensual') ?>/${materiaId}/${currentMonth + 1}/${currentYear}`)
            .then(response => response.json())
            .then(data => {
                renderAttendanceTable(data.estudiantes, data.dias_en_mes);
                updateStats(data.estadisticas);
                monthYearDisplay.textContent = getMonthName(currentMonth) + ' ' + currentYear;
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudieron cargar los datos de asistencia', 'error');
            });
    }

    function renderAttendanceTable(estudiantes, diasEnMes) {
        let html = '<thead class="table-dark"><tr>';
        html += '<th class="text-center">Estudiante</th>';

        for (let dia = 1; dia <= diasEnMes; dia++) {
            const fecha = new Date(currentYear, currentMonth, dia);
            const diaSemana = fecha.toLocaleDateString('es-ES', { weekday: 'short' });
            const esFinDeSemana = fecha.getDay() === 0 || fecha.getDay() === 6;

            html += `<th class="text-center ${esFinDeSemana ? 'table-secondary' : ''}" title="${diaSemana}">${dia}<br><small>${diaSemana}</small></th>`;
        }

        html += '<th class="text-center">%</th></tr></thead><tbody>';

        estudiantes.forEach(estudiante => {
            html += `<tr>
                <td class="fw-bold">${estudiante.nombre_estudiante} ${estudiante.apellido_estudiante}</td>`;

            for (let dia = 1; dia <= diasEnMes; dia++) {
                const fecha = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
                const estado = estudiante.asistencia[dia] || '';
                const fechaObj = new Date(currentYear, currentMonth, dia);
                const esFinDeSemana = fechaObj.getDay() === 0 || fechaObj.getDay() === 6;

                html += `<td class="text-center ${esFinDeSemana ? 'table-light' : ''}">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input attendance-checkbox" type="checkbox"
                               data-estudiante="${estudiante.id}" data-fecha="${fecha}"
                               ${estado === 'Presente' ? 'checked' : ''}>
                    </div>
                </td>`;
            }

            // Calcular porcentaje
            const diasPresentes = Object.values(estudiante.asistencia).filter(e => e === 'Presente').length;
            const porcentaje = diasEnMes > 0 ? Math.round((diasPresentes / diasEnMes) * 100) : 0;
            const colorClass = porcentaje >= 90 ? 'text-success' : porcentaje >= 70 ? 'text-warning' : 'text-danger';

            html += `<td class="text-center fw-bold ${colorClass}">${porcentaje}%</td></tr>`;
        });

        html += '</tbody>';
        attendanceTable.innerHTML = html;

        // Agregar event listeners a los checkboxes
        document.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const estudianteId = this.dataset.estudiante;
                const fecha = this.dataset.fecha;
                const estado = this.checked ? 'Presente' : 'Ausente';

                if (!attendanceData[estudianteId]) attendanceData[estudianteId] = {};
                attendanceData[estudianteId][fecha] = estado;

                updateRowPercentage(this.closest('tr'));
            });
        });
    }

    function updateRowPercentage(row) {
        const checkboxes = row.querySelectorAll('.attendance-checkbox');
        const checkedCount = row.querySelectorAll('.attendance-checkbox:checked').length;
        const percentage = checkboxes.length > 0 ? Math.round((checkedCount / checkboxes.length) * 100) : 0;
        const percentageCell = row.querySelector('td:last-child');
        const colorClass = percentage >= 90 ? 'text-success' : percentage >= 70 ? 'text-warning' : 'text-danger';

        percentageCell.className = `text-center fw-bold ${colorClass}`;
        percentageCell.textContent = `${percentage}%`;
    }

    function updateStats(estadisticas) {
        const html = `
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">${estadisticas.total_presentes || 0}</h5>
                        <p class="card-text">Días Presentes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">${estadisticas.total_ausentes || 0}</h5>
                        <p class="card-text">Días Ausentes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">${estadisticas.porcentaje_presentes || 0}%</h5>
                        <p class="card-text">Asistencia General</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">${estadisticas.total_estudiantes || 0}</h5>
                        <p class="card-text">Total Estudiantes</p>
                    </div>
                </div>
            </div>
        `;
        statsContainer.innerHTML = html;
    }

    function saveAttendances() {
        Swal.fire({
            title: '¿Guardar asistencias?',
            text: '¿Está seguro que desea guardar todas las asistencias?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const asistencias = [];

                Object.keys(attendanceData).forEach(estudianteId => {
                    Object.keys(attendanceData[estudianteId]).forEach(fecha => {
                        asistencias.push({
                            estudiante_id: estudianteId,
                            fecha: fecha,
                            estado: attendanceData[estudianteId][fecha]
                        });
                    });
                });

                fetch('<?= base_url('profesores/guardarAsistenciasMensuales') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        materia_id: materiaId,
                        asistencias: asistencias
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Guardado!', 'Las asistencias se han guardado correctamente.', 'success');
                        attendanceData = {};
                        loadAttendanceTable();
                    } else {
                        Swal.fire('Error', data.message || 'No se pudieron guardar las asistencias.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error al guardar las asistencias.', 'error');
                });
            }
        });
    }

    function resetAttendances() {
        Swal.fire({
            title: '¿Restablecer asistencias?',
            text: '¿Está seguro que desea restablecer todas las asistencias? Se perderán todos los cambios no guardados.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, restablecer',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                attendanceData = {};
                loadAttendanceTable();
                Swal.fire('¡Restablecido!', 'Las asistencias han sido restablecidas.', 'success');
            }
        });
    }

    function markAllPresent() {
        Swal.fire({
            title: '¿Marcar todos como presentes?',
            text: '¿Está seguro que desea marcar a todos los estudiantes como presentes en todas las fechas?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, marcar todos',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
                    if (!checkbox.checked) {
                        checkbox.checked = true;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });
                Swal.fire('¡Completado!', 'Todos los estudiantes han sido marcados como presentes.', 'success');
            }
        });
    }

    function markAllAbsent() {
        Swal.fire({
            title: '¿Marcar todos como ausentes?',
            text: '¿Está seguro que desea marcar a todos los estudiantes como ausentes en todas las fechas?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, marcar todos',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelectorAll('.attendance-checkbox').forEach(checkbox => {
                    if (checkbox.checked) {
                        checkbox.checked = false;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });
                Swal.fire('¡Completado!', 'Todos los estudiantes han sido marcados como ausentes.', 'success');
            }
        });
    }

    function getMonthName(monthIndex) {
        const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        return months[monthIndex];
    }

    // Cargar tabla inicial
    loadAttendanceTable();
});
</script>
<?= $this->endSection() ?>
