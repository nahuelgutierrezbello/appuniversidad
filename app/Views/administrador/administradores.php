<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestión de Administradores - Instituto Superior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('styles.css') ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
</head>
<body class="administradores-page">
    <?= view('templates/NavbarAdmin') ?>
    <header class="bg-dark text-white py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Gestión de Administradores</h1>
            <p class="lead">Sistema de administración integral de administradores</p>
        </div>
    </header>
    <section class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Hero Section Institucional -->
                    <div class="text-center mb-5 py-5 bg-gradient-primary text-white rounded-3 shadow-lg" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-lg-8 mx-auto">
                                    <i class="fas fa-university fa-4x mb-4 text-white"></i>
                                    <h1 class="display-4 fw-bold mb-3">Instituto Superior 57</h1>
                                    <p class="lead fs-4 mb-4">Formando profesionales desde 1990 con excelencia académica e innovación tecnológica</p>
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="bg-white bg-opacity-10 rounded p-3">
                                                <h3 class="text-white mb-1">1,250+</h3>
                                                <small>Estudiantes Activos</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="bg-white bg-opacity-10 rounded p-3">
                                                <h3 class="text-white mb-1">12</h3>
                                                <small>Carreras Ofrecidas</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="bg-white bg-opacity-10 rounded p-3">
                                                <h3 class="text-white mb-1">85</h3>
                                                <small>Profesores Calificados</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visión y Valores -->
                    <div class="row mb-5">
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-lg bg-light">
                                <div class="card-body p-5">
                                    <div class="row align-items-center">
                                        <div class="col-lg-8">
                                            <h3 class="text-primary mb-3"><i class="fas fa-eye me-3"></i>Visión Institucional</h3>
                                            <p class="lead mb-4">Ser reconocidos como la institución educativa de referencia en formación técnica superior, destacándonos por la excelencia académica, la innovación pedagógica y el compromiso con el desarrollo integral de nuestros estudiantes.</p>
                                            <h5 class="text-muted mb-3">Valores que nos definen:</h5>
                                            <div class="d-flex flex-wrap gap-2">
                                                <span class="badge bg-primary fs-6 px-3 py-2">Excelencia</span>
                                                <span class="badge bg-success fs-6 px-3 py-2">Innovación</span>
                                                <span class="badge bg-info fs-6 px-3 py-2">Integridad</span>
                                                <span class="badge bg-secondary fs-6 px-3 py-2">Compromiso</span>
                                                <span class="badge bg-secondary fs-6 px-3 py-2">Responsabilidad</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 text-center">
                                            <i class="fas fa-award fa-6x text-primary opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rol del Administrador -->
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold text-dark mb-4">Rol del Administrador</h2>
                        <p class="lead text-muted fs-5 mb-4">Como administrador, tienes acceso completo al sistema de gestión del instituto. Gestiona administradores, profesores, estudiantes, carreras y más a través del menú de navegación.</p>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="alert alert-info border-0 shadow-sm bg-gradient-info text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <div>
                                        <h5 class="alert-heading mb-1">Tu Responsabilidad es Clave</h5>
                                        <p class="mb-0">Mantén la integridad académica y facilita un entorno óptimo para el éxito estudiantil.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Funciones Clave -->
                    <h3 class="text-center fw-bold mb-4 text-dark">Funciones Clave del Administrador</h3>
                    <div class="row g-4 mb-5">
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-lg hover-lift" style="transition: transform 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="fas fa-users-cog fa-2x text-primary"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Gestión de Usuarios</h5>
                                    <p class="card-text text-muted">Administra perfiles con acceso seguro y controlado.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-lg hover-lift" style="transition: transform 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="fas fa-graduation-cap fa-2x text-success"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Administración Académica</h5>
                                    <p class="card-text text-muted">Supervisa curricula y programas educativos.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-lg hover-lift" style="transition: transform 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="fas fa-chart-line fa-2x text-info"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Monitoreo y Reportes</h5>
                                    <p class="card-text text-muted">Genera estadísticas y análisis de datos.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-lg hover-lift" style="transition: transform 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="fas fa-shield-alt fa-2x text-dark"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Seguridad</h5>
                                    <p class="card-text text-muted">Garantiza integridad y cumplimiento normativo.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas Detalladas -->
                    <div class="bg-light rounded-3 p-5 mb-5 shadow-sm">
                        <h3 class="text-center fw-bold mb-4 text-dark">Estadísticas Institucionales</h3>
                        <div class="row text-center g-4">
                            <div class="col-md-3">
                                <div class="p-3 bg-white rounded-3 shadow-sm">
                                    <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                                    <h4 class="text-primary fw-bold">1,250+</h4>
                                    <p class="text-muted mb-0">Estudiantes Activos</p>
                                    <small class="text-muted">Matriculados vigentes</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-white rounded-3 shadow-sm">
                                    <i class="fas fa-chalkboard-teacher fa-3x text-success mb-3"></i>
                                    <h4 class="text-success fw-bold">85</h4>
                                    <p class="text-muted mb-0">Profesores</p>
                                    <small class="text-muted">Docentes especializados</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-white rounded-3 shadow-sm">
                                    <i class="fas fa-book fa-3x text-dark mb-3"></i>
                                    <h4 class="text-warning fw-bold">12</h4>
                                    <p class="text-muted mb-0">Carreras</p>
                                    <small class="text-muted">Programas académicos</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-white rounded-3 shadow-sm">
                                    <i class="fas fa-book-open fa-3x text-info mb-3"></i>
                                    <h4 class="text-info fw-bold">200+</h4>
                                    <p class="text-muted mb-0">Materias</p>
                                    <small class="text-muted">Asignaturas disponibles</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Llamado a la Acción -->
                    <div class="text-center">
                        <div class="alert alert-success border-0 shadow-lg bg-gradient-success text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                            <i class="fas fa-rocket fa-2x mb-3"></i>
                            <h4 class="alert-heading fw-bold">¡Impulsa la Excelencia Educativa!</h4>
                            <p class="mb-0 fs-5">Tu rol como administrador es fundamental para mantener los estándares de calidad y apoyar el crecimiento de nuestra comunidad académica.</p>
                        </div>
                    </div>
                    <h3 class="mb-3 text-center">Operaciones CRUD Disponibles</h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-plus-circle fa-2x text-success mb-3"></i>
                                    <h5 class="card-title">Crear</h5>
                                    <p class="card-text">Registrar nuevos administradores, profesores, estudiantes, carreras, categorías y modalidades.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-eye fa-2x text-info mb-3"></i>
                                    <h5 class="card-title">Leer</h5>
                                    <p class="card-text">Buscar y visualizar información detallada de usuarios y entidades del sistema.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-edit fa-2x text-dark mb-3"></i>
                                    <h5 class="card-title">Actualizar</h5>
                                    <p class="card-text">Editar y actualizar datos de administradores, profesores, estudiantes y otras entidades.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-trash fa-2x text-danger mb-3"></i>
                                    <h5 class="card-title">Eliminar</h5>
                                    <p class="card-text">Remover registros de usuarios y entidades del sistema de manera segura.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <main class="container my-5">


    </main>




    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-university me-2"></i>Instituto Superior 57</h5>
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Av. Siempre Viva 742, Springfield</p>
                    <p class="mb-2"><i class="fas fa-phone me-2"></i>+54 11 3456-7890</p>
                    <p class="mb-0"><i class="fas fa-envelope me-2"></i>info@instituto57.edu.ar</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Formando profesionales desde 1990</h5>
                    <p class="mb-0">Excelencia académica e innovación tecnológica</p>
                </div>
            </div>
            <hr class="my-3" />
            <div class="text-center">
                <p class="mb-0">&copy; 2023 Gestión Instituto. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // Pasa la configuración de PHP a JavaScript
        window.APP_CONFIG = {
            baseUrl: "<?= base_url('/') ?>",
            flash: {
                success: "<?= session()->getFlashdata('success') ?>",
                error: "<?= session()->getFlashdata('error') ?>"
            }
        };
    </script>
    <script src="<?= base_url('app.js') ?>"></script>
</body>
</html>
