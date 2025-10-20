<?= $this->extend('Dashboard_Profesores/layout_profesor') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt"></i>
                        Control de Asistencia Mensual
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" id="btnGuardar">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="btnVolver">
                            <i class="fas fa-arrow-left"></i> Volver al Dashboard
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Información de la Materia -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-book"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Materia</span>
                                    <span class="info-box-number" id="materiaNombre">
                                        <?= esc($materia['nombre_materia'] ?? 'Cargando...') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-user-graduate"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Profesor</span>
                                    <span class="info-box-number">
                                        <?= esc($profesor['nombre_profesor'] ?? 'Cargando...') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selector de Mes y Año -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="mesSelector">Mes:</label>
                            <select class="form-control" id="mesSelector">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="anioSelector">Año:</label>
                            <input type="number" class="form-control" id="anioSelector" min="2020" max="2030" value="<?= date('Y') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button type="button" class="btn btn-primary" id="btnCargarMes">
                                <i class="fas fa-search"></i> Cargar Mes
                            </button>
                        </div>
                    </div>

                    <!-- Estadísticas del Mes -->
                    <div class="row mb-4" id="estadisticasContainer" style="display: none;">
                        <div class="col-md-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="totalPresentes">0</h3>
                                    <p>Presentes</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 id="totalAusentes">0</h3>
                                    <p>Ausentes</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 id="totalTarde">0</h3>
                                    <p>Tarde</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="totalEstudiantes">0</h3>
                                    <p>Estudiantes</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="row mb-4" id="accionesContainer" style="display: none;">
                        <div class="col-12">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success btn-sm" id="btnTodosPresentes">
                                    <i class="fas fa-check-circle"></i> Todos Presentes
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" id="btnTodosAusentes">
                                    <i class="fas fa-times-circle"></i> Todos Ausentes
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" id="btnResetear">
                                    <i class="fas fa-undo"></i> Resetear Todo
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Asistencia -->
                    <div class="table-responsive" id="tablaContainer" style="display: none;">
                        <div id="tablaAsistencia">
                            <!-- La tabla se carga dinámicamente aquí -->
                        </div>
                    </div>

                    <!-- Mensajes -->
                    <div id="mensajeContainer" style="display: none;" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Acción</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="confirmarMensaje">
                ¿Está seguro de que desea realizar esta acción?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarAccion">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const materiaId = <?= json_encode($materia['id'] ?? null) ?>;
    let datosAsistencia = [];
    let accionPendiente = null;

    // Establecer mes y año actuales
    const fechaActual = new Date();
    $('#mesSelector').val(fechaActual.getMonth() + 1);
    $('#anioSelector').val(fechaActual.getFullYear());

    // Cargar datos iniciales si hay materia
    if (materiaId) {
        cargarDatosMes();
    }

    // Evento para cargar mes
    $('#btnCargarMes').click(function() {
        cargarDatosMes();
    });

    // Evento para guardar cambios
    $('#btnGuardar').click(function() {
        guardarCambios();
    });

    // Evento para volver al dashboard
    $('#btnVolver').click(function() {
        window.location.href = '<?= base_url('profesores/dashboard') ?>';
    });

    // Eventos para acciones rápidas
    $('#btnTodosPresentes').click(function() {
        mostrarConfirmacion('¿Marcar a todos los estudiantes como presentes en todo el mes?', 'marcarTodosPresentes');
    });

    $('#btnTodosAusentes').click(function() {
        mostrarConfirmacion('¿Marcar a todos los estudiantes como ausentes en todo el mes?', 'marcarTodosAusentes');
    });

    $('#btnResetear').click(function() {
        mostrarConfirmacion('¿Eliminar todas las asistencias del mes? Esta acción no se puede deshacer.', 'resetearAsistencias');
    });

    // Evento para confirmar acción
    $('#btnConfirmarAccion').click(function() {
        if (accionPendiente) {
            ejecutarAccionRapida(accionPendiente);
        }
        $('#confirmarModal').modal('hide');
    });

    function cargarDatosMes() {
        const mes = $('#mesSelector').val();
        const anio = $('#anioSelector').val();

        mostrarMensaje('Cargando datos...', 'info');

        $.ajax({
            url: '<?= base_url('profesores/getDatosAsistenciaMensual') ?>/' + materiaId + '/' + mes + '/' + anio,
            method: 'GET',
            success: function(response) {
                if (response.estudiantes) {
                    datosAsistencia = response.estudiantes;
                    // Cargar la tabla HTML desde el servidor
                    $.ajax({
                        url: '<?= base_url('profesores/getTablaAsistenciaMensual') ?>/' + materiaId + '/' + mes + '/' + anio,
                        method: 'GET',
                        success: function(html) {
                            $('#tablaAsistencia').html(html);
                            actualizarEstadisticas(response.estadisticas);
                            mostrarContenedores();
                            ocultarMensaje();
                            // Re-inicializar eventos después de cargar la tabla
                            inicializarEventosTabla();
                        },
                        error: function() {
                            mostrarMensaje('Error al cargar la tabla', 'danger');
                        }
                    });
                } else {
                    mostrarMensaje('Error al cargar los datos', 'danger');
                }
            },
            error: function() {
                mostrarMensaje('Error de conexión', 'danger');
            }
        });
    }

    function generarTabla(diasEnMes) {
        // Generar header de días
        let headerDias = '';
        for (let dia = 1; dia <= diasEnMes; dia++) {
            headerDias += `<th class="text-center" style="width: 30px;">${dia}</th>`;
        }
        $('#diasNumeros').html(headerDias);

        // Generar filas de estudiantes
        let filas = '';
        datosAsistencia.forEach(function(estudiante) {
            filas += `
                <tr>
                    <td class="align-middle">
                        <strong>${estudiante.nombre_estudiante} ${estudiante.apellido_estudiante}</strong>
                    </td>`;

            for (let dia = 1; dia <= diasEnMes; dia++) {
                const estado = estudiante.asistencia[dia] || '';
                const clase = getClaseEstado(estado);
                filas += `
                    <td class="text-center">
                        <select class="form-control form-control-sm estado-select ${clase}"
                                data-estudiante-id="${estudiante.id}"
                                data-dia="${dia}">
                            <option value="" ${estado === '' ? 'selected' : ''}></option>
                            <option value="Presente" ${estado === 'Presente' ? 'selected' : ''}>P</option>
                            <option value="Ausente" ${estado === 'Ausente' ? 'selected' : ''}>A</option>
                            <option value="Tarde" ${estado === 'Tarde' ? 'selected' : ''}>T</option>
                        </select>
                    </td>`;
            }

            filas += '</tr>';
        });

        $('#tablaBody').html(filas);

        // Evento para cambios en los select
        $('.estado-select').change(function() {
            const estudianteId = $(this).data('estudiante-id');
            const dia = $(this).data('dia');
            const nuevoEstado = $(this).val();

            // Actualizar datos locales
            if (!datosAsistencia.find(e => e.id == estudianteId).asistencia) {
                datosAsistencia.find(e => e.id == estudianteId).asistencia = {};
            }
            datosAsistencia.find(e => e.id == estudianteId).asistencia[dia] = nuevoEstado;

            // Actualizar clase CSS
            $(this).removeClass('presente ausente tarde');
            $(this).addClass(getClaseEstado(nuevoEstado));
        });
    }

    function getClaseEstado(estado) {
        switch (estado) {
            case 'Presente': return 'presente';
            case 'Ausente': return 'ausente';
            case 'Tarde': return 'tarde';
            default: return '';
        }
    }

    function actualizarEstadisticas(estadisticas) {
        $('#totalPresentes').text(estadisticas.total_presentes || 0);
        $('#totalAusentes').text(estadisticas.total_ausentes || 0);
        $('#totalTarde').text(estadisticas.total_tarde || 0);
        $('#totalEstudiantes').text(estadisticas.total_estudiantes || 0);
    }

    function mostrarContenedores() {
        $('#estadisticasContainer').show();
        $('#accionesContainer').show();
        $('#tablaContainer').show();
    }

    function inicializarEventosTabla() {
        // Evento para cambios en los checkboxes
        $('.attendance-checkbox').change(function() {
            const estudianteId = $(this).data('estudiante');
            const fecha = $(this).data('fecha');
            const estado = $(this).is(':checked') ? 'Presente' : 'Ausente';

            // Actualizar datos locales
            if (!datosAsistencia.find(e => e.id == estudianteId).asistencia) {
                datosAsistencia.find(e => e.id == estudianteId).asistencia = {};
            }
            const dia = new Date(fecha).getDate();
            datosAsistencia.find(e => e.id == estudianteId).asistencia[dia] = estado;

            // Actualizar estadísticas en tiempo real
            actualizarEstadisticasEnTiempoReal();
        });
    }

    function actualizarEstadisticasEnTiempoReal() {
        let totalPresentes = 0;
        let totalAusentes = 0;
        let totalEstudiantes = datosAsistencia.length;

        datosAsistencia.forEach(function(estudiante) {
            let presentesEstudiante = 0;
            let totalDias = Object.keys(estudiante.asistencia).length;

            Object.values(estudiante.asistencia).forEach(function(estado) {
                if (estado === 'Presente') {
                    presentesEstudiante++;
                }
            });

            if (presentesEstudiante > totalDias / 2) {
                totalPresentes++;
            } else {
                totalAusentes++;
            }
        });

        $('#totalPresentes').text(totalPresentes);
        $('#totalAusentes').text(totalAusentes);
        $('#totalEstudiantes').text(totalEstudiantes);
    }

    function guardarCambios() {
        const asistencias = [];

        $('.attendance-checkbox').each(function() {
            const estudianteId = $(this).data('estudiante');
            const fecha = $(this).data('fecha');
            const estado = $(this).is(':checked') ? 'Presente' : 'Ausente';

            asistencias.push({
                estudiante_id: estudianteId,
                fecha: fecha,
                estado: estado
            });
        });

        if (asistencias.length === 0) {
            mostrarMensaje('No hay datos para guardar', 'warning');
            return;
        }

        mostrarMensaje('Guardando cambios...', 'info');

        $.ajax({
            url: '<?= base_url('profesores/guardarAsistenciasMensuales') ?>',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                materia_id: materiaId,
                asistencias: asistencias
            }),
            success: function(response) {
                if (response.success) {
                    mostrarMensaje(response.message, 'success');
                    // Recargar datos para actualizar estadísticas
                    setTimeout(function() {
                        cargarDatosMes();
                    }, 1000);
                } else {
                    mostrarMensaje(response.message || 'Error al guardar', 'danger');
                }
            },
            error: function() {
                mostrarMensaje('Error de conexión', 'danger');
            }
        });
    }

    function mostrarConfirmacion(mensaje, accion) {
        $('#confirmarMensaje').text(mensaje);
        accionPendiente = accion;
        $('#confirmarModal').modal('show');
    }

    function ejecutarAccionRapida(accion) {
        const mes = $('#mesSelector').val();
        const anio = $('#anioSelector').val();

        mostrarMensaje('Ejecutando acción...', 'info');

        $.ajax({
            url: '<?= base_url('profesores/' + accion) ?>',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                materia_id: materiaId,
                mes: parseInt(mes),
                anio: parseInt(anio)
            }),
            success: function(response) {
                if (response.success) {
                    mostrarMensaje(response.message, 'success');
                    // Recargar datos
                    cargarDatosMes();
                } else {
                    mostrarMensaje(response.message || 'Error en la acción', 'danger');
                }
            },
            error: function() {
                mostrarMensaje('Error de conexión', 'danger');
            }
        });
    }

    function mostrarMensaje(mensaje, tipo) {
        const alertClass = `alert alert-${tipo}`;
        $('#mensajeContainer').html(`<div class="${alertClass}" role="alert">${mensaje}</div>`).show();
    }

    function ocultarMensaje() {
        $('#mensajeContainer').hide();
    }
});
</script>

<style>
.estado-select {
    font-size: 0.8rem;
    padding: 0.2rem;
}

.presente {
    background-color: #d4edda !important;
    color: #155724 !important;
}

.ausente {
    background-color: #f8d7da !important;
    color: #721c24 !important;
}

.tarde {
    background-color: #fff3cd !important;
    color: #856404 !important;
}

.table th {
    background-color: #f8f9fa;
    font-weight: bold;
}

.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}
</style>

<?= $this->endSection() ?>
