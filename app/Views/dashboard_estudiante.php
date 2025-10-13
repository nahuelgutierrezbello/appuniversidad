<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante - Instituto Superior 57</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('styles.css') ?>">
</head>
<body>
    <?= view('templates/Navbar') ?>

    <div class="container my-5">
        <h1 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i>Dashboard del Estudiante</h1>

        <!-- Sección Perfil -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Perfil del Estudiante</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($estudiante)): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> <?= esc($estudiante['nombre_estudiante']) ?></p>
                            <p><strong>DNI:</strong> <?= esc($estudiante['dni']) ?></p>
                            <p><strong>Email:</strong> <?= esc($estudiante['email']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fecha de Nacimiento:</strong> <?= esc($estudiante['fecha_nacimiento']) ?></p>
                            <p><strong>Edad:</strong> <?= esc($estudiante['edad']) ?> años</p>
                            <p><strong>Carrera:</strong> <?= esc($estudiante['nombre_carrera']) ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No hay datos del estudiante disponibles.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sección Notas -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Notas</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Calificación</th>
                            <th>Fecha de Evaluación</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($notas)): ?>
                            <?php foreach ($notas as $nota): ?>
                                <tr>
                                    <td><?= esc($nota['nombre_materia']) ?></td>
                                    <td><?= esc($nota['calificacion']) ?></td>
                                    <td><?= esc($nota['fecha_evaluacion']) ?></td>
                                    <td><?= esc($nota['observaciones'] ?? 'Sin observaciones') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay notas disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección Materias Inscritas -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i>Materias Inscritas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!empty($materias_inscritas)): ?>
                        <?php foreach ($materias_inscritas as $inscripcion): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= esc($inscripcion['nombre_materia']) ?> (<?= esc($inscripcion['codigo_materia']) ?>)</h6>
                                        <p class="card-text">Estado: <?= esc($inscripcion['estado_inscripcion'] ?? 'Confirmada') ?></p>
                                        <p class="card-text">Fecha de Inscripción: <?= esc($inscripcion['fecha_inscripcion']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center">No hay materias inscritas.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sección Estadísticas -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Estadísticas</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h3 class="text-primary"><?= esc($estadisticas['promedio_general']) ?></h3>
                        <p>Promedio General</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-success"><?= esc($estadisticas['progreso']) ?>%</h3>
                        <p>Progreso en Carrera</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-info"><?= esc($estadisticas['materias_aprobadas']) ?></h3>
                        <p>Materias Aprobadas</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-danger"><?= esc($estadisticas['materias_pendientes']) ?></h3>
                        <p>Materias Pendientes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección Materiales de Estudio -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Materiales de Estudio</h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="materialesAccordion">
                    <?php if (!empty($materias_inscritas)): ?>
                        <?php $count = 0; ?>
                        <?php foreach ($materias_inscritas as $inscripcion): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?= $count ?>">
                                    <button class="accordion-button <?= $count === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $count ?>" aria-expanded="<?= $count === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $count ?>">
                                        <?= esc($inscripcion['nombre_materia']) ?>
                                    </button>
                                </h2>
                                <div id="collapse<?= $count ?>" class="accordion-collapse collapse <?= $count === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $count ?>" data-bs-parent="#materialesAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                            <?php if (!empty($materiales_por_materia[$inscripcion['materia_id']])): ?>
                                                <?php foreach ($materiales_por_materia[$inscripcion['materia_id']] as $material): ?>
                                                    <li class="list-group-item">
                                                        <a href="<?= esc($material['url'] ?? '#') ?>" class="text-decoration-none">
                                                            <i class="fas fa-<?= esc($material['tipo'] ?? 'file') ?> me-2 text-<?= esc($material['color'] ?? 'primary') ?>"></i>
                                                            <?= esc($material['titulo']) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li class="list-group-item">No hay materiales disponibles para esta materia.</li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">No hay materias inscritas para mostrar materiales.</p>
                    <?php endif; ?>
                </div>
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
            <hr class="my-3">
            <div class="text-center">
                <p class="mb-0">&copy; 2023 Gestión Instituto. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
