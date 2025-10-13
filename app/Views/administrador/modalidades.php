<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestión de Modalidades - Instituto Superior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('styles.css') ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
</head>
<body class="modalidades-page">
    <?= view('templates/NavbarAdmin') ?>
    <header class="bg-dark text-white py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Gestión de Modalidades</h1>
            <p class="lead">Sistema de administración de modalidades académicas</p>
        </div>
    </header>

    <main class="container my-5">
        <section class="row justify-content-center mb-5">
            <div class="col-lg-9">
                <div class="card shadow">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0"><i class="fas fa-graduation-cap me-2"></i> Registrar Nueva Modalidad</h2>
                    </div>
                    <div class="card-body">
                        <?php if (session()->has('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>
                        <form id="modalidadForm" method="post" action="<?= base_url('modalidades/registrar') ?>">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="codigo_modalidad" class="form-label">Código de la Modalidad</label>
                                <input type="text" class="form-control" id="codigo_modalidad" name="codigo_modalidad" required />
                            </div>
                            <div class="mb-3">
                                <label for="nombre_modalidad" class="form-label">Nombre de la Modalidad</label>
                                <input type="text" class="form-control" id="nombre_modalidad" name="nombre_modalidad" required />
                            </div>
                            <div class="mb-3">
                                <label for="carrera_id" class="form-label">Carrera</label>
                                <select class="form-control" id="carrera_id" name="carrera_id" required>
                                    <option value="">Seleccione una carrera</option>
                                    <?php foreach ($carreras as $carrera): ?>
                                        <option value="<?= $carrera['id'] ?>"><?= $carrera['nombre_carrera'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Registrar Modalidad
                                </button>
                            </div>
                            <div id="validationAlert-modalidadForm" class="text-danger text-sm mt-2 d-none"></div>
                        </form>
                        <div id="registerResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-9">
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="card shadow h-100">
                            <div class="card-header bg-info text-white">
                                <h2 class="h5 mb-0"><i class="fas fa-search me-2"></i> Buscar Modalidad por ID</h2>
                            </div>
                            <div class="card-body">
                                <form id="searchModalidadForm">
                                    <div class="mb-3">
                                        <label for="searchModalidadId" class="form-label">ID de la Modalidad</label>
                                        <input type="number" class="form-control" id="searchModalidadId" required min="1" />
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-search me-1"></i> Buscar
                                        </button>
                                    </div>
                                    <div id="validationAlert-searchModalidadForm" class="text-danger text-sm mt-2 d-none"></div>
                                </form>
                                <div id="modalidadDetails" class="mt-3 p-3 border rounded d-none">
                                    <p class="mb-1"><strong>ID:</strong> <span id="detailId"></span></p>
                                    <p class="mb-1"><strong>Código:</strong> <span id="detailCodigo"></span></p>
                                    <p class="mb-1"><strong>Nombre:</strong> <span id="detailNombre"></span></p>
                                    <p class="mb-0"><strong>Carrera:</strong> <span id="detailCarrera"></span></p>
                                    <button id="clearModalidadDetails" class="btn btn-sm btn-outline-secondary mt-3"><i class="fas fa-times me-1"></i> Limpiar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-9">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0"><i class="fas fa-list me-2"></i> Listado de Modalidades</h2>
                        <button id="refreshModalidadesBtn" class="btn btn-sm btn-light float-end">
                            <i class="fas fa-sync-alt me-1"></i> Recargar Todos
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="modalidadesTable" class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                       <th>ID</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Carrera</th>
                                           <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="modalidadesTableBody">
                                    <?php if(isset($modalidades) && count($modalidades) > 0): ?>
                                        <?php foreach($modalidades as $modalidad): ?>
                                            <tr>
                                                <td><?= esc($modalidad['id']) ?></td>
                                                <td><?= esc($modalidad['codigo_modalidad']) ?></td>
                                                <td><?= esc($modalidad['nombre_modalidad']) ?></td>
                                                <td>
                                                    <?php
                                                    $carreraNombre = '';
                                                    foreach ($carreras as $carrera) {
                                                        if ($carrera['id'] == $modalidad['carrera_id']) {
                                                            $carreraNombre = $carrera['nombre_carrera'];
                                                            break;
                                                        }
                                                    }
                                                    echo esc($carreraNombre);
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm edit-btn" data-id="<?= esc($modalidad['id']) ?>" data-bs-toggle="modal" data-bs-target="#editModalidadModal">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                    <form action="<?= base_url('modalidades/delete/' . $modalidad['id']) ?>" method="post" class="d-inline delete-form">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="5" class="text-center">No hay modalidades registradas.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Edición -->
    <div class="modal fade" id="editModalidadModal" tabindex="-1" aria-labelledby="editModalidadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalidadModalLabel">Editar Modalidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editModalidadForm" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_codigo_modalidad" class="form-label">Código de la Modalidad</label>
                            <input type="text" class="form-control" id="edit_codigo_modalidad" name="codigo_modalidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nombre_modalidad" class="form-label">Nombre de la Modalidad</label>
                            <input type="text" class="form-control" id="edit_nombre_modalidad" name="nombre_modalidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_carrera_id" class="form-label">Carrera</label>
                            <select class="form-control" id="edit_carrera_id" name="carrera_id" required>
                                <option value="">Seleccione una carrera</option>
                                <?php foreach ($carreras as $carrera): ?>
                                    <option value="<?= $carrera['id'] ?>"><?= $carrera['nombre_carrera'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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
