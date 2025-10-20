// Archivo JavaScript separado para la funcionalidad de asistencia mensual
// Este archivo maneja toda la lógica del lado cliente para el control de asistencia

$(document).ready(function() {
    // Variables globales
    let materiaId = null;
    let datosAsistencia = [];
    let accionPendiente = null;

    // Inicialización
    function init() {
        // Obtener el ID de la materia desde un elemento oculto o data attribute
        materiaId = $('#materiaData').data('materia-id') || getMateriaIdFromUrl();

        // Establecer mes y año actuales
        const fechaActual = new Date();
        $('#mesSelector').val(fechaActual.getMonth() + 1);
        $('#anioSelector').val(fechaActual.getFullYear());

        // Configurar eventos
        configurarEventos();

        // Cargar datos iniciales si hay materia
        if (materiaId) {
            cargarDatosMes();
        }
    }

    // Configurar todos los eventos
    function configurarEventos() {
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
            window.location.href = baseUrl + 'profesores/dashboard';
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

        // Delegación de eventos para elementos dinámicos
        $(document).on('change', '.estado-select', function() {
            actualizarEstadoLocal($(this));
        });
    }

    // Cargar datos del mes seleccionado
    function cargarDatosMes() {
        const mes = $('#mesSelector').val();
        const anio = $('#anioSelector').val();

        mostrarMensaje('Cargando datos...', 'info');

        $.ajax({
            url: baseUrl + 'profesores/getDatosAsistenciaMensual/' + materiaId + '/' + mes + '/' + anio,
            method: 'GET',
            success: function(response) {
                if (response.estudiantes) {
                    datosAsistencia = response.estudiantes;
                    generarTabla(response.dias_en_mes);
                    actualizarEstadisticas(response.estadisticas);
                    mostrarContenedores();
                    ocultarMensaje();
                } else {
                    mostrarMensaje('Error al cargar los datos', 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar datos:', error);
                mostrarMensaje('Error de conexión al cargar datos', 'danger');
            }
        });
    }

    // Generar la tabla de asistencia
    function generarTabla(diasEnMes) {
        // Generar header de días
        let headerDias = '';
        for (let dia = 1; dia <= diasEnMes; dia++) {
            headerDias += `<th class="text-center dia-header" style="width: 30px; cursor: pointer;" data-dia="${dia}" title="Haga clic para marcar todos como presentes en este día">${dia}</th>`;
        }
        $('#diasNumeros').html(headerDias);

        // Generar filas de estudiantes
        let filas = '';
        datosAsistencia.forEach(function(estudiante, index) {
            filas += generarFilaEstudiante(estudiante, diasEnMes, index);
        });

        $('#tablaBody').html(filas);

        // Configurar eventos para headers de días
        configurarEventosDias();
    }

    // Generar fila para un estudiante
    function generarFilaEstudiante(estudiante, diasEnMes, index) {
        let fila = `
            <tr data-estudiante-id="${estudiante.id}">
                <td class="align-middle estudiante-info">
                    <div class="d-flex align-items-center">
                        <div class="estudiante-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem; margin-right: 10px;">
                            ${estudiante.nombre_estudiante.charAt(0)}${estudiante.apellido_estudiante.charAt(0)}
                        </div>
                        <div>
                            <strong>${estudiante.nombre_estudiante} ${estudiante.apellido_estudiante}</strong>
                            <br><small class="text-muted">ID: ${estudiante.id}</small>
                        </div>
                    </div>
                </td>`;

        for (let dia = 1; dia <= diasEnMes; dia++) {
            const estado = estudiante.asistencia[dia] || '';
            const clase = getClaseEstado(estado);
            fila += `
                <td class="text-center">
                    <select class="form-control form-control-sm estado-select ${clase}"
                            data-estudiante-id="${estudiante.id}"
                            data-dia="${dia}"
                            data-row="${index}">
                        <option value="" ${estado === '' ? 'selected' : ''}></option>
                        <option value="Presente" ${estado === 'Presente' ? 'selected' : ''}>P</option>
                        <option value="Ausente" ${estado === 'Ausente' ? 'selected' : ''}>A</option>
                        <option value="Tarde" ${estado === 'Tarde' ? 'selected' : ''}>T</option>
                    </select>
                </td>`;
        }

        fila += '</tr>';
        return fila;
    }

    // Configurar eventos para headers de días
    function configurarEventosDias() {
        $('.dia-header').click(function() {
            const dia = $(this).data('dia');
            mostrarConfirmacion(`¿Marcar a todos los estudiantes como presentes el día ${dia}?`, 'marcarDiaPresente', {dia: dia});
        });
    }

    // Actualizar estado local cuando cambia un select
    function actualizarEstadoLocal($select) {
        const estudianteId = $select.data('estudiante-id');
        const dia = $select.data('dia');
        const nuevoEstado = $select.val();

        // Actualizar datos locales
        const estudiante = datosAsistencia.find(e => e.id == estudianteId);
        if (estudiante) {
            if (!estudiante.asistencia) {
                estudiante.asistencia = {};
            }
            estudiante.asistencia[dia] = nuevoEstado;

            // Actualizar clase CSS
            $select.removeClass('presente ausente tarde');
            $select.addClass(getClaseEstado(nuevoEstado));
        }
    }

    // Obtener clase CSS para estado
    function getClaseEstado(estado) {
        switch (estado) {
            case 'Presente': return 'presente';
            case 'Ausente': return 'ausente';
            case 'Tarde': return 'tarde';
            default: return '';
        }
    }

    // Actualizar estadísticas mostradas
    function actualizarEstadisticas(estadisticas) {
        $('#totalPresentes').text(estadisticas.total_presentes || 0);
        $('#totalAusentes').text(estadisticas.total_ausentes || 0);
        $('#totalTarde').text(estadisticas.total_tarde || 0);
        $('#totalEstudiantes').text(estadisticas.total_estudiantes || 0);

        // Actualizar porcentajes si están disponibles
        if (estadisticas.porcentaje_presentes !== undefined) {
            $('#porcentajePresentes').text(estadisticas.porcentaje_presentes + '%');
            $('#porcentajeAusentes').text(estadisticas.porcentaje_ausentes + '%');
            $('#porcentajeTarde').text(estadisticas.porcentaje_tarde + '%');
        }
    }

    // Mostrar contenedores de datos
    function mostrarContenedores() {
        $('#estadisticasContainer').show();
        $('#accionesContainer').show();
        $('#tablaContainer').show();
    }

    // Guardar cambios realizados
    function guardarCambios() {
        const asistencias = prepararDatosAsistencia();

        if (asistencias.length === 0) {
            mostrarMensaje('No hay cambios para guardar', 'warning');
            return;
        }

        mostrarMensaje('Guardando cambios...', 'info');

        $.ajax({
            url: baseUrl + 'profesores/guardarAsistenciasMensuales',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                materia_id: materiaId,
                asistencias: asistencias
            }),
            success: function(response) {
                manejarRespuestaGuardado(response);
            },
            error: function(xhr, status, error) {
                console.error('Error al guardar:', error);
                mostrarMensaje('Error de conexión al guardar cambios', 'danger');
            }
        });
    }

    // Preparar datos de asistencia para envío
    function prepararDatosAsistencia() {
        const asistencias = [];
        const mes = $('#mesSelector').val();
        const anio = $('#anioSelector').val();

        datosAsistencia.forEach(function(estudiante) {
            if (estudiante.asistencia) {
                Object.keys(estudiante.asistencia).forEach(function(dia) {
                    const estado = estudiante.asistencia[dia];
                    if (estado) {
                        const fecha = `${anio}-${mes.padStart(2, '0')}-${dia.padStart(2, '0')}`;
                        asistencias.push({
                            estudiante_id: estudiante.id,
                            fecha: fecha,
                            estado: estado
                        });
                    }
                });
            }
        });

        return asistencias;
    }

    // Manejar respuesta del guardado
    function manejarRespuestaGuardado(response) {
        if (response.success) {
            mostrarMensaje(response.message, 'success');
            // Recargar datos para actualizar estadísticas
            setTimeout(function() {
                cargarDatosMes();
            }, 1000);
        } else {
            mostrarMensaje(response.message || 'Error al guardar', 'danger');
        }
    }

    // Mostrar modal de confirmación
    function mostrarConfirmacion(mensaje, accion, datosExtra = {}) {
        $('#confirmarMensaje').text(mensaje);
        accionPendiente = {accion: accion, datos: datosExtra};
        $('#confirmarModal').modal('show');
    }

    // Ejecutar acción rápida
    function ejecutarAccionRapida(datosAccion) {
        const mes = $('#mesSelector').val();
        const anio = $('#anioSelector').val();

        mostrarMensaje('Ejecutando acción...', 'info');

        let url = baseUrl + 'profesores/' + datosAccion.accion;
        let data = {
            materia_id: materiaId,
            mes: parseInt(mes),
            anio: parseInt(anio)
        };

        // Agregar datos extra si existen
        if (datosAccion.datos) {
            Object.assign(data, datosAccion.datos);
        }

        $.ajax({
            url: url,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                if (response.success) {
                    mostrarMensaje(response.message, 'success');
                    // Recargar datos
                    cargarDatosMes();
                } else {
                    mostrarMensaje(response.message || 'Error en la acción', 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en acción rápida:', error);
                mostrarMensaje('Error de conexión', 'danger');
            }
        });
    }

    // Mostrar mensaje al usuario
    function mostrarMensaje(mensaje, tipo) {
        const alertClass = `alert alert-${tipo} alert-dismissible fade show`;
        const mensajeHtml = `
            <div class="${alertClass}" role="alert">
                ${mensaje}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>`;
        $('#mensajeContainer').html(mensajeHtml).show();

        // Auto-ocultar mensajes de éxito después de 5 segundos
        if (tipo === 'success') {
            setTimeout(function() {
                $('#mensajeContainer .alert').fadeOut();
            }, 5000);
        }
    }

    // Ocultar mensaje
    function ocultarMensaje() {
        $('#mensajeContainer').hide();
    }

    // Obtener ID de materia desde URL
    function getMateriaIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('materia_id');
    }

    // Funciones de utilidad adicionales
    function marcarDiaPresente(dia) {
        $('.estado-select[data-dia="' + dia + '"]').val('Presente').trigger('change');
    }

    function marcarDiaAusente(dia) {
        $('.estado-select[data-dia="' + dia + '"]').val('Ausente').trigger('change');
    }

    // Exponer funciones globales si es necesario
    window.AsistenciaMensual = {
        init: init,
        cargarDatosMes: cargarDatosMes,
        guardarCambios: guardarCambios
    };

    // Inicializar cuando el documento esté listo
    init();
});
