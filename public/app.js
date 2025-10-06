// La función $(document).ready() asegura que todo el código JavaScript dentro de ella
// se ejecute solo después de que toda la página HTML (el DOM) se haya cargado por completo.
// Esto previene errores al intentar manipular elementos que aún no existen.
$(document).ready(function () {
    // Deshabilitar restauración de scroll para que al refrescar vaya al inicio
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0, 0);

    console.log('Script cargado'); // Agregado para depuración
    console.log('Elemento #ciencia-datos-link encontrado:', $('#ciencia-datos-link').length);

    // Lee la URL base de la aplicación desde un objeto global (window.APP_CONFIG)
    // que se define en las vistas PHP. Esto hace que las URLs de AJAX sean portátiles.
    const BASE_URL = window.APP_CONFIG.baseUrl;

    // --- Lógica para Estudiantes ---

    // Evento de clic para los botones de "Editar" en la tabla de estudiantes.
    // Usa delegación de eventos para funcionar incluso si la tabla se recarga.
    $('#studentsTable').on('click', '.edit-btn', function () {
        // Obtiene el ID del estudiante desde el atributo 'data-id' del botón.
        const studentId = $(this).data('id');

        // Petición AJAX para obtener los datos del estudiante desde el servidor.
        $.ajax({
            url: `${BASE_URL}estudiantes/edit/${studentId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) { // Se ejecuta si la petición es exitosa.
                // Rellena los campos del formulario del modal de edición con los datos recibidos.
                $('#edit_id_est').val(response.id_est);
                $('#edit_nest').val(response.nest);
                $('#edit_dni').val(response.dni);
                $('#edit_edad').val(response.edad);
                $('#edit_email').val(response.email);
                $('#edit_fecha_nac').val(response.fecha_nac);
                $('#edit_id_car').val(response.id_car);
                // Actualiza la URL del 'action' del formulario para que apunte al método de actualización correcto.
                $('#editStudentForm').attr('action', `${BASE_URL}estudiantes/update/${studentId}`);
            },
            error: function() { // Se ejecuta si hay un error en la petición.
                Swal.fire('Error', 'No se pudieron cargar los datos del estudiante.', 'error');
            }
        });
    });

    // Evento de clic para los botones de "Eliminar" en la tabla de estudiantes.
    // Ahora intercepta el envío del formulario de borrado.
    $('body').on('submit', '.delete-form', function (e) {
        e.preventDefault(); // Previene el envío normal del formulario.
        const form = this; // 'this' es el formulario que se está enviando.
        // Llama a la función reutilizable que muestra la confirmación.
        showDeleteConfirmation(form);
    });

    // Evento de envío para el formulario de búsqueda de estudiante por ID.
    $('#searchStudentForm').on('submit', function(e) {
        e.preventDefault(); // Previene que el formulario se envíe y recargue la página.
        // Obtiene el ID del estudiante del campo de entrada.
        const studentId = $('#searchStudentId').val();
        // Si el campo está vacío, no hace nada.
        if (!studentId) return;

        // Petición AJAX para buscar al estudiante.
        $.ajax({
            url: `${BASE_URL}estudiantes/search/${studentId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#detailId').text(response.id_est);
                $('#detailName').text(response.nest);
                $('#detailCareer').text(response.ncar || 'No asignada');
                // Muestra el contenedor de detalles que estaba oculto.
                $('#studentDetails').removeClass('d-none');
            },
            error: function(xhr) {
                // Muestra un mensaje de error si el estudiante no encuentra.
                const errorMsg = xhr.responseJSON ? xhr.responseJSON.error : 'Error al buscar.';
                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });

    // Evento de clic para el botón "Limpiar" en la búsqueda por ID.
    $('#clearStudentDetails').on('click', () => $('#studentDetails').addClass('d-none'));

    // Evento de envío para el formulario de búsqueda de estudiantes por carrera.
    $('#searchStudentByCareerForm').on('submit', function(e) {
        e.preventDefault();
        // Obtiene el ID de la carrera seleccionada en el menú desplegable.
        const careerId = $('#searchCareer').val();
        if (!careerId) {
            // Muestra una advertencia si no se ha seleccionado ninguna carrera.
            Swal.fire('Atención', 'Por favor, seleccione una carrera.', 'warning');
            return;
        }

        $.ajax({
            url: `${BASE_URL}estudiantes/search/carrera/${careerId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const resultsContainer = $('#studentsByCareerResults');
                const clearBtnContainer = $('#clearCareerResultsContainer');
                resultsContainer.empty(); // Limpia cualquier resultado de búsqueda anterior.

                // Si la respuesta contiene estudiantes, los recorre y crea una tarjeta para cada uno.
                if (response.length > 0) {
                    response.forEach(student => {
                        const studentCard = `
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">${student.nest}</h5>
                                        <p class="card-text mb-1"><strong>DNI:</strong> ${student.dni}</p>
                                        <p class="card-text"><strong>Email:</strong> ${student.email}</p>
                                    </div>
                                </div>
                            </div>`;
                        resultsContainer.append(studentCard);
                    });
                } else {
                    // Si no se encuentran estudiantes, muestra un mensaje informativo.
                    resultsContainer.html('<div class="col-12"><p class="text-center text-muted">No se encontraron estudiantes en esta carrera.</p></div>');
                }
                // Muestra el contenedor del botón "Limpiar Búsqueda".
                clearBtnContainer.removeClass('d-none');
            }
        });
    });

    // Evento de clic para el botón "Limpiar Búsqueda" de la búsqueda por carrera.
    $('#clearCareerResultsBtn').on('click', function() {
        $('#studentsByCareerResults').empty(); // Vacía el contenedor de resultados.
        $('#clearCareerResultsContainer').addClass('d-none'); // Oculta el botón de limpiar.
        $('#searchCareer').val(''); // Opcional: resetea el menú desplegable a su estado inicial.
    });

    // --- Lógica para generar código de carrera en tiempo real ---
    let debounceTimer;
    $('#registerName').on('input', function() {
        // Limpia el temporizador anterior cada vez que se presiona una tecla.
        clearTimeout(debounceTimer);

        const nombreCarrera = $(this).val().trim();
        const careerCodeInput = $('#careerCode');

        if (nombreCarrera.length < 3) {
            careerCodeInput.val(''); // Limpia el campo si el nombre es muy corto
            return;
        }

        // Configura un nuevo temporizador. El código se ejecutará 500ms después de que el usuario deje de escribir.
        // Esto evita hacer una llamada AJAX en cada pulsación de tecla (debounce).
        debounceTimer = setTimeout(() => {
            // Codifica el nombre para que sea seguro en una URL
            const nombreCodificado = encodeURIComponent(nombreCarrera);

            $.ajax({
                url: `${BASE_URL}registrarCarrera/generar-codigo/${nombreCodificado}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.codigo) {
                        careerCodeInput.val(response.codigo);
                    }
                },
                error: function() {
                    // No hacer nada si hay un error, para no confundir al usuario.
                    console.error('Error al generar el código de carrera.');
                }
            });
        }, 500);
    });

    // --- Lógica para Carreras ---
    // La lógica para Carreras y Categorías sigue el mismo patrón que la de Estudiantes:
    // 1. Evento para el botón de editar (AJAX para llenar el modal).
    // 2. Evento para el botón de eliminar (llama a la confirmación).
    // 3. Evento para el formulario de búsqueda por ID (AJAX para mostrar detalles).
    $('#careersTable').on('click', '.edit-car-btn', function() {
        const careerId = $(this).data('id');

        $.ajax({
            url: `${BASE_URL}registrarCarrera/edit/${careerId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#edit_id_car').val(response.id_car);
                $('#edit_ncar').val(response.ncar);
                $('#edit_codcar').val(response.codcar);
                $('#edit_id_cat').val(response.id_cat);
                $('#edit_modalidad').val(response.id_mod);
                $('#editCareerForm').attr('action', `${BASE_URL}registrarCarrera/update/${careerId}`);
            },
            error: function() {
                Swal.fire('Error', 'No se pudieron cargar los datos de la carrera.', 'error');
            }
        });
    });

    // --- Lógica para Categorías ---
    $('#categoriesTable').on('click', '.edit-cat-btn', function() {
        const categoryId = $(this).data('id');

        $.ajax({
            url: `${BASE_URL}categorias/edit/${categoryId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#edit_id_cat').val(response.id_cat);
                $('#edit_ncat').val(response.ncat);
                $('#edit_codcat').val(response.codcat);
                $('#editCategoryForm').attr('action', `${BASE_URL}categorias/update/${categoryId}`);
            },
            error: function() {
                Swal.fire('Error', 'No se pudieron cargar los datos de la categoría.', 'error');
            }
        });
    });

    $('#searchCategoryForm').on('submit', function(e) {
        e.preventDefault();
        const categoryId = $('#searchCategoryId').val();
        if (!categoryId) return;

        $.ajax({
            url: `${BASE_URL}categorias/search/${categoryId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#detailCategoryId').text(response.id_cat);
                $('#detailCategoryName').text(response.ncat);
                $('#categoryDetails').removeClass('d-none');
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON ? xhr.responseJSON.error : 'Error al buscar.';
                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });

    $('#clearCategoryDetails').on('click', () => $('#categoryDetails').addClass('d-none'));


    // --- Funciones reutilizables ---

    /**
     * Muestra una ventana de confirmación de SweetAlert antes de realizar una acción de borrado.
     * @param {HTMLFormElement} form - El formulario que se enviará si el usuario confirma.
     */
    function showDeleteConfirmation(form) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, ¡eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Envía el formulario si el usuario confirma.
            }
        });
    }

    // --- Lógica para carga dinámica de carreras en la página de inicio ---

    // Manejador de eventos genérico para todos los enlaces de carreras
    $('body').on('click', 'a[id$="-link"], a[id^="ver-detalle-"]', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        let url = '';

        // Determina la URL de AJAX basada en el ID del enlace clickeado
        if (id.includes('ciencia-datos')) url = 'ajax/ciencia_datos';
        else if (id.includes('profesorado-matematica')) url = 'ajax/profesorado_matematica';
        else if (id.includes('programacion-web')) url = 'ajax/programacion_web';
        else if (id.includes('profesorado-ingles')) url = 'ajax/profesorado_ingles';
        else if (id.includes('educacion-inicial')) url = 'ajax/educacion_inicial';
        else if (id.includes('enfermeria')) url = 'ajax/enfermeria';
        else if (id.includes('seguridad-higiene')) url = 'ajax/seguridad_higiene';

        if (!url) return; // Si no se encontró una URL, no hace nada

        // Cierra el menú desplegable
        var dropdownElement = document.getElementById('navbarDropdownOfertaAcademica');
        var dropdownInstance = bootstrap.Dropdown.getInstance(dropdownElement) || new bootstrap.Dropdown(dropdownElement);
        dropdownInstance.hide();

        // Scroll suave a la sección y carga del contenido
        $('html, body').animate({
            scrollTop: $('#careers').offset().top - 80 // 80px de offset por el navbar
        }, 800);
        cargarContenidoCarrera(url);
    });

    // Evento para el botón "Volver" que hace scroll suave hacia la parte superior de la página.
    $('body').on('click', '#volver-oferta-default', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0 // Llevamos la vista al inicio de la página
        }, 800);
    });

    /**
     * Función reutilizable para cargar contenido de carreras vía AJAX.
     * @param {string} url - La URL del controlador AJAX a la que se llamará.
     * @param {string} containerSelector - Selector del contenedor donde cargar el contenido (opcional).
     */

    // Función reutilizable para cargar contenido vía AJAX
    function cargarContenidoCarrera(url, containerSelector = '#careers') {
        const contentContainer = $(containerSelector);

        // Añadimos una clase para dar feedback visual inmediato (cambia el fondo)
        contentContainer.addClass('loading-content');

        // Muestra un efecto de "fade out" en el contenedor actual
        contentContainer.fadeOut(200, function() {
            // Realiza la petición AJAX
            $.ajax({
                url: `${BASE_URL}${url}`, // CORRECCIÓN: Se añade la variable BASE_URL a la URL de la petición.
                type: 'GET',
                success: function(response) {
                    let finalHtml = response;

                    // Si la URL no es la de la vista por defecto, añadimos el botón "Volver".
                    if (url !== 'ajax/oferta_academica_default') {
                        const volverBtnHtml = `
                            <div class="container mt-4 text-center" data-aos="fade-up">
                                <button id="volver-oferta-default" class="btn btn-secondary btn-lg px-4 py-2">
                                    <i class="fas fa-arrow-up me-2"></i>Volver Arriba
                                </button>
                            </div>
                        `;
                        finalHtml += volverBtnHtml;
                    }

                    contentContainer.html(finalHtml).removeClass('loading-content').fadeIn(300);

                    // Re-inicializa las animaciones de AOS para el nuevo contenido
                    AOS.init({ once: true }); // Usamos 'once: true' para que la animación ocurra solo una vez por carga.
                },
                error: function() {
                    contentContainer.html('<p class="text-center text-danger">Error al cargar el contenido.</p>').removeClass('loading-content').fadeIn(300);
                }
            });
        });
    }

    // Comprueba si existen mensajes "flash" de éxito o error pasados desde el controlador PHP.
    // Estos mensajes se usan para notificar al usuario el resultado de una acción (ej: "Estudiante registrado").
    // Si encuentra un mensaje, lo muestra con SweetAlert.
    if (window.APP_CONFIG.flash.success) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: window.APP_CONFIG.flash.success,
            showConfirmButton: false,
            timer: 2000
        });
    }

    if (window.APP_CONFIG.flash.error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: window.APP_CONFIG.flash.error
        });
    }

    // Lógica para el botón de toggle test
    let ajaxTestLoaded = false;
    $('#toggle-test-btn').on('click', function() {
        $('#ajax-test-section').slideToggle();
        if (!ajaxTestLoaded) {
            $.get(`${BASE_URL}ajax/test`, function(data) {
                $('#ajax-test-content').html(data);
                ajaxTestLoaded = true;
            });
        }
    });



});
