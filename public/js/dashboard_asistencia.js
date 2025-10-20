// JavaScript para manejar la funcionalidad de asistencia en el dashboard del profesor
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard de profesor cargado correctamente.');

    // Variables globales para cada materia
    const attendanceData = {};

    // Inicializar controles para cada materia
    document.querySelectorAll('.accordion-item').forEach(item => {
        const materiaId = item.querySelector('.attendance-table').dataset.materiaId;
        if (materiaId) {
            initializeMateriaControls(materiaId);
        }
    });

    function initializeMateriaControls(materiaId) {
        const monthSelect = document.getElementById(`month-select-${materiaId}`);
        const yearSelect = document.getElementById(`year-select-${materiaId}`);
        const attendanceTable = document.querySelector(`.attendance-table[data-materia-id="${materiaId}"]`);
        const saveBtn = document.querySelector(`.save-btn[data-materia-id="${materiaId}"]`);
        const resetBtn = document.querySelector(`.reset-btn[data-materia-id="${materiaId}"]`);
        const markAllPresentBtn = document.querySelector(`.mark-all-present[data-materia-id="${materiaId}"]`);
        const markAllAbsentBtn = document.querySelector(`.mark-all-absent[data-materia-id="${materiaId}"]`);
        const monthYearDisplay = document.querySelector(`.month-year-display[data-materia-id="${materiaId}"]`);
        const statsContainer = document.querySelector(`.stats-container[data-materia-id="${materiaId}"]`);
        const collapseElement = document.getElementById(`collapse${materiaId}`);

        // Inicializar años
        const now = new Date();
        const currentYear = now.getFullYear();
        const currentMonth = now.getMonth();

        // Seleccionar mes y año actuales
        monthSelect.value = currentMonth;
        for (let year = currentYear - 2; year <= currentYear + 2; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            if (year === currentYear) option.selected = true;
            yearSelect.appendChild(option);
        }

        // Event listeners
        monthSelect.addEventListener('change', () => loadAttendanceTable(materiaId));
        yearSelect.addEventListener('change', () => loadAttendanceTable(materiaId));
        saveBtn.addEventListener('click', () => saveAttendances(materiaId));
        resetBtn.addEventListener('click', () => resetAttendances(materiaId));
        markAllPresentBtn.addEventListener('click', () => markAllPresent(materiaId));
        markAllAbsentBtn.addEventListener('click', () => markAllAbsent(materiaId));

        // Cargar tabla cuando se abre el acordeón
        collapseElement.addEventListener('shown.bs.collapse', () => {
            loadAttendanceTable(materiaId);
        });

        // Cargar tabla automáticamente
        loadAttendanceTable(materiaId);

        // Mostrar el acordeón para que la tabla sea visible
        if (collapseElement) {
            collapseElement.classList.add('show');
        }
    }

    function loadAttendanceTable(materiaId) {
        const monthSelect = document.getElementById(`month-select-${materiaId}`);
        const yearSelect = document.getElementById(`year-select-${materiaId}`);
        const attendanceTable = document.querySelector(`.attendance-table[data-materia-id="${materiaId}"]`);
        const monthYearDisplay = document.querySelector(`.month-year-display[data-materia-id="${materiaId}"]`);
        const statsContainer = document.querySelector(`.stats-container[data-materia-id="${materiaId}"]`);

        const currentMonth = parseInt(monthSelect.value);
        const currentYear = parseInt(yearSelect.value);

        // Mostrar loading
        attendanceTable.innerHTML = '<tr><td colspan="32" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></td></tr>';

        fetch('<?= base_url('profesores/getDatosAsistenciaMensual') ?>/' + materiaId + '/' + (currentMonth + 1) + '/' + currentYear)
            .then(response => response.json())
            .then(data => {
                renderAttendanceTable(materiaId, data.estudiantes, data.dias_en_mes, currentMonth, currentYear);
                updateStats(materiaId, data.estadisticas);
                monthYearDisplay.textContent = getMonthName(currentMonth) + ' ' + currentYear;
            })
            .catch(error => {
                console.error('Error:', error);
                attendanceTable.innerHTML = '<tr><td colspan="32" class="text-center text-danger">Error al cargar los datos</td></tr>';
                Swal.fire('Error', 'No se pudieron cargar los datos de asistencia', 'error');
            });
    }

    function renderAttendanceTable(materiaId, estudiantes, diasEnMes, currentMonth, currentYear) {
        const attendanceTable = document.querySelector(`.attendance-table[data-materia-id="${materiaId}"]`);

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
                               data-materia-id="${materiaId}" data-estudiante="${estudiante.id}" data-fecha="${fecha}"
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
        document.querySelectorAll(`.attendance-checkbox[data-materia-id="${materiaId}"]`).forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const estudianteId = this.dataset.estudiante;
                const fecha = this.dataset.fecha;
                const estado = this.checked ? 'Presente' : 'Ausente';

                if (!attendanceData[materiaId]) attendanceData[materiaId] = {};
                if (!attendanceData[materiaId][estudianteId]) attendanceData[materiaId][estudianteId] = {};
                attendanceData[materiaId][estudianteId][fecha] = estado;

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

    function updateStats(materiaId, estadisticas) {
        const statsContainer = document.querySelector(`.stats-container[data-materia-id="${materiaId}"]`);

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

    function saveAttendances(materiaId) {
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

                if (attendanceData[materiaId]) {
                    Object.keys(attendanceData[materiaId]).forEach(estudianteId => {
                        Object.keys(attendanceData[materiaId][estudianteId]).forEach(fecha => {
                            asistencias.push({
                                estudiante_id: estudianteId,
                                fecha: fecha,
                                estado: attendanceData[materiaId][estudianteId][fecha]
                            });
                        });
                    });
                }

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
                        if (attendanceData[materiaId]) delete attendanceData[materiaId];
                        loadAttendanceTable(materiaId);
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

    function resetAttendances(materiaId) {
        Swal.fire({
            title: '¿Restablecer asistencias?',
            text: '¿Está seguro que desea restablecer todas las asistencias? Se perderán todos los cambios no guardados.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, restablecer',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if (attendanceData[materiaId]) delete attendanceData[materiaId];
                loadAttendanceTable(materiaId);
                Swal.fire('¡Restablecido!', 'Las asistencias han sido restablecidas.', 'success');
            }
        });
    }

    function markAllPresent(materiaId) {
        Swal.fire({
            title: '¿Marcar todos como presentes?',
            text: '¿Está seguro que desea marcar a todos los estudiantes como presentes en todas las fechas?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, marcar todos',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelectorAll(`.attendance-checkbox[data-materia-id="${materiaId}"]`).forEach(checkbox => {
                    if (!checkbox.checked) {
                        checkbox.checked = true;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });
                Swal.fire('¡Completado!', 'Todos los estudiantes han sido marcados como presentes.', 'success');
            }
        });
    }

    function markAllAbsent(materiaId) {
        Swal.fire({
            title: '¿Marcar todos como ausentes?',
            text: '¿Está seguro que desea marcar a todos los estudiantes como ausentes en todas las fechas?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, marcar todos',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelectorAll(`.attendance-checkbox[data-materia-id="${materiaId}"]`).forEach(checkbox => {
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
});
