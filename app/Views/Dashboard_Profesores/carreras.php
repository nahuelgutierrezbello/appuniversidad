<?= $this->extend('Dashboard_Profesores/layout_profesor') ?>

<?= $this->section('title') ?>
    Mis Materias
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted mb-0 small">Panel de Gestión</p>
            <h2 class="mb-0">Mis Materias</h2>
        </div>
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 text-muted">Bienvenido, Prof. <?= esc($profesor['nombre_profesor']) ?></h5>
        </div>
    </div>

    <div class="accordion" id="materiasAccordion">
        <?php if (!empty($materias)): ?>
            <?php foreach ($materias as $index => $materia): ?>
                <?php
                    $materia_id = $materia['id'];
                    $estudiantes = $estudiantes_por_materia[$materia_id] ?? [];
                    $notas_materia = $notas_por_materia[$materia_id] ?? [];
                    $asistencias_materia = $asistencias_por_materia[$materia_id] ?? [];

                    // Organizar notas por estudiante para fácil acceso
                    // Organiza las notas por estudiante para un acceso más fácil en la vista
                    $notas_por_estudiante = [];
                    foreach ($notas_materia as $nota) {
                        $notas_por_estudiante[$nota['estudiante_id']] = $nota;
                    }
                ?>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading<?= $materia_id ?>">
                        <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $materia_id ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $materia_id ?>">
                            <div class="d-flex justify-content-between w-100 align-items-center pe-3">
                                <span class="fw-bold fs-5"><?= esc($materia['nombre_materia']) ?></span>
                                <span class="badge bg-primary rounded-pill p-2">
                                    <i class="fas fa-book me-1"></i>
                                    Código: <?= esc($materia['codigo_materia']) ?>
                                </span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse<?= $materia_id ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $materia_id ?>" data-bs-parent="#materiasAccordion">
                        <div class="accordion-body">
                            <ul class="nav nav-tabs" id="tabMateria<?= $materia_id ?>" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="asistencia-tab-<?= $materia_id ?>" data-bs-toggle="tab" data-bs-target="#asistencia-content-<?= $materia_id ?>" type="button" role="tab" aria-controls="asistencia-content-<?= $materia_id ?>" aria-selected="true">
                                        <i class="fas fa-calendar-check me-1"></i>Asistencias
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="notas-tab-<?= $materia_id ?>" data-bs-toggle="tab" data-bs-target="#notas-content-<?= $materia_id ?>" type="button" role="tab" aria-controls="notas-content-<?= $materia_id ?>" aria-selected="false">
                                        <i class="fas fa-clipboard-list me-1"></i>Notas
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="tabContentMateria<?= $materia_id ?>">
                                <!-- Pestaña de Asistencias (AHORA ACTIVA POR DEFECTO) -->
                                <div class="tab-pane fade show active" id="asistencia-content-<?= $materia_id ?>" role="tabpanel" aria-labelledby="asistencia-tab-<?= $materia_id ?>">                                    
                                    <?= view('Dashboard_Profesores/_asistencia_table', ['materia_id' => $materia_id, 'estudiantes' => $estudiantes]) ?>
                                </div>

                                <!-- Pestaña de Notas -->
                                <div class="tab-pane fade" id="notas-content-<?= $materia_id ?>" role="tabpanel" aria-labelledby="notas-tab-<?= $materia_id ?>">
                                    <h4 class="mb-3">Cargar/Ver Notas</h4>
                                    <?php if (!empty($estudiantes)): ?>
                                        <form action="<?= base_url('profesores/guardar-notas') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="materia_id" value="<?= $materia_id ?>">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Estudiante</th>
                                                            <th>DNI</th>
                                                            <th>Calificación</th>
                                                            <th>Fecha Evaluación</th>
                                                            <th>Observaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($estudiantes as $estudiante): ?>
                                                            <?php $nota_actual = $notas_por_estudiante[$estudiante['id']] ?? null; ?>
                                                            <tr>
                                                                <td><?= esc($estudiante['nombre_estudiante']) ?></td>
                                                                <td><?= esc($estudiante['dni']) ?></td>
                                                                <td><input type="number" name="nota[<?= $estudiante['id'] ?>]" class="form-control form-control-sm" min="0" max="10" step="0.1" value="<?= esc($nota_actual['calificacion'] ?? '') ?>" placeholder="1-10"></td>
                                                                <td><input type="date" name="fecha_evaluacion[<?= $estudiante['id'] ?>]" class="form-control form-control-sm" value="<?= esc($nota_actual['fecha_evaluacion'] ?? date('Y-m-d')) ?>"></td>
                                                                <td><input type="text" name="observaciones[<?= $estudiante['id'] ?>]" class="form-control form-control-sm" placeholder="Opcional" value="<?= esc($nota_actual['observaciones'] ?? '') ?>"></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-end mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar Notas</button>
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <div class="alert alert-info">No hay estudiantes inscritos en esta materia.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning">No tienes materias asignadas actualmente.</div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Mover el estilo aquí dentro de una etiqueta <style> o, mejor aún, a un archivo CSS.
    // Por ahora, lo dejamos aquí para mantener la funcionalidad.
    const style = document.createElement('style');
    style.innerHTML = `
    .fc-event {
        cursor: pointer;
    }
    `;
    document.head.appendChild(style);

    document.addEventListener('DOMContentLoaded', function() {
    const calendars = {};

    // Observador para inicializar calendarios cuando se muestran
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const calendarEl = entry.target;
                const materiaId = calendarEl.closest('.asistencia-mensual').dataset.materiaId;

                // Inicializar solo si no ha sido inicializado antes
                if (!calendars[materiaId]) {
                    initializeCalendar(calendarEl, materiaId);
                    calendars[materiaId] = true; // Marcar como inicializado
                }
                // Dejar de observar este elemento una vez inicializado
                observer.unobserve(calendarEl);
            }
        });
    }, { threshold: 0.1 });

    // Observar cada instancia de calendario
    document.querySelectorAll('.calendar-instance').forEach(el => {
        observer.observe(el);
    });

    function initializeCalendar(calendarEl, materiaId) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                const start = fetchInfo.startStr.split('T')[0];
                const end = fetchInfo.endStr.split('T')[0];
                fetch(`<?= base_url('profesores/get-eventos-asistencia') ?>/${materiaId}?start=${start}&end=${end}`)
                    .then(response => response.json())
                    .then(data => {
                        const events = data.map(evento => ({
                            title: evento.title,
                            start: evento.start,
                            backgroundColor: evento.backgroundColor,
                            borderColor: evento.borderColor,
                            extendedProps: evento.extendedProps
                        }));
                        successCallback(events);
                    })
                    .catch(failureCallback);
            },
            datesSet: function(dateInfo) {
                // Se dispara cuando cambia el mes/vista
                const start = dateInfo.view.currentStart;
                const mes = start.getMonth() + 1;
                const anio = start.getFullYear();
                cargarDatosMes(materiaId, mes, anio);
            },
            height: 'auto',
            eventClick: function(info) {
                // Aquí puedes agregar una acción al hacer clic en un evento, como abrir un modal con detalles.
                console.log('Evento clickeado:', info.event);
            }
        });
        calendar.render();

        // Carga inicial de datos para el mes actual
        const today = new Date();
        cargarDatosMes(materiaId, today.getMonth() + 1, today.getFullYear());
    }

    function cargarDatosMes(materiaId, mes, anio) {
        // Cargar estadísticas
        fetch(`<?= base_url('profesores/get-estadisticas-mes') ?>/${materiaId}?mes=${mes}&anio=${anio}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById(`total-presentes-${materiaId}`).textContent = data.total_presentes || 0;
                document.getElementById(`total-ausentes-${materiaId}`).textContent = data.total_ausentes || 0;
                document.getElementById(`total-tarde-${materiaId}`).textContent = data.total_tarde || 0;
                document.getElementById(`total-clases-${materiaId}`).textContent = data.total_clases || 0;
            })
            .catch(error => console.error('Error cargando estadísticas:', error));

        // Cargar resumen de estudiantes
        fetch(`<?= base_url('profesores/get-resumen-estudiantes') ?>/${materiaId}?mes=${mes}&anio=${anio}`)
            .then(response => response.json())
            .then(estudiantes => {
                const tbody = document.getElementById(`resumen-estudiantes-${materiaId}`);
                tbody.innerHTML = '';

                if (estudiantes.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No hay datos de asistencia para este mes.</td></tr>';
                    return;
                }

                estudiantes.forEach(est => {
                    const porcentaje = est.total_clases > 0 ? Math.round((est.presentes / est.total_clases) * 100) : 0;
                    const row = document.createElement('tr');
                    let badgeClass = 'bg-danger';
                    if (porcentaje >= 80) {
                        badgeClass = 'bg-success';
                    } else if (porcentaje >= 60) {
                        badgeClass = 'bg-warning';
                    }

                    row.innerHTML = `
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-primary text-white me-2" style="width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                                    ${est.nombre_estudiante.charAt(0).toUpperCase()}
                                </div>
                                <div>
                                    <div class="fw-bold">${est.nombre_estudiante}</div>
                                    <small class="text-muted">DNI: ${est.dni || 'N/A'}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center text-success fw-bold">${est.presentes}</td>
                        <td class="text-center text-danger fw-bold">${est.ausentes}</td>
                        <td class="text-center text-warning fw-bold">${est.tarde}</td>
                        <td class="text-center">
                            <span class="badge ${badgeClass}">
                                ${porcentaje}%
                            </span>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error('Error cargando resumen de estudiantes:', error));
    }
});
</script>
<?= $this->endSection() ?>
