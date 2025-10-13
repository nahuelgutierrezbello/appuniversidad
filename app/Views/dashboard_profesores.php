<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Profesor - Instituto Superior 57</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('styles.css') ?>">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Arial', sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Layout general */
    .dashboard-layout {
      flex: 1;
      display: flex;
      min-height: calc(100vh - 56px); /* sin navbar */
    }

    /* Sidebar */
    .sidebar {
      background: #212529;
      color: #fff;
      width: 250px;
      padding: 1.2rem;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
    }

    .sidebar h4 {
      color: #ffc107;
      margin-bottom: 1rem;
      text-align: center;
    }

    .sidebar a {
      color: #adb5bd;
      text-decoration: none;
      padding: 0.6rem 0.8rem;
      margin-bottom: 0.4rem;
      border-radius: 6px;
      transition: background 0.2s, color 0.2s;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: #495057;
      color: #fff;
    }

    /* Contenido principal */
    .main-content {
      flex-grow: 1;
      padding: 2rem;
      overflow-x: hidden;
    }

    /* Tarjetas */
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .stats-card {
      text-align: center;
      padding: 1.5rem;
      border-radius: 10px;
    }
    .materia-card {
      cursor: pointer;
      transition: transform 0.2s;
    }
    .materia-card:hover {
      transform: translateY(-4px);
    }

    footer {
      background: #212529;
      color: #fff;
      padding: 2rem 0;
      margin-top: auto;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .dashboard-layout {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
      }
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>

<body>
  <?= view('templates/Navbar') ?>

  <div class="dashboard-layout">
    <!-- Sidebar -->
    <div class="sidebar">
      <h4><i class="fas fa-chalkboard-teacher me-2"></i>Profesor</h4>
      <a href="#" class="active"><i class="fas fa-home"></i>Inicio</a>
      <a href="#"><i class="fas fa-book"></i>Materias</a>
      <a href="#"><i class="fas fa-user-graduate"></i>Estudiantes</a>
      <a href="#"><i class="fas fa-calendar-check"></i>Asistencias</a>
      <a href="#"><i class="fas fa-clipboard-list"></i>Calificaciones</a>
      <a href="#"><i class="fas fa-chart-line"></i>Reportes</a>
      <a href="#"><i class="fas fa-cog"></i>Configuración</a>
    </div>

    <!-- Contenido -->
    <div class="main-content container-fluid">

      <!-- PERFIL -->
      <div class="card mb-4 p-4 bg-primary text-white">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-user-circle fa-4x"></i>
          </div>
          <div>
            <h2 class="mb-1"><?= esc($profesor['nombre_profesor'] ?? 'Profesor') ?></h2>
            <p class="mb-0">Legajo: <?= esc($profesor['legajo'] ?? '-') ?></p>
            <p class="mb-0">Carrera: <?= esc($profesor['nombre_carrera'] ?? '-') ?></p>
          </div>
        </div>
      </div>

      <!-- ESTADÍSTICAS -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card stats-card bg-success text-white">
            <i class="fas fa-book fa-2x mb-2"></i>
            <h4><?= esc($estadisticas['total_materias'] ?? 0) ?></h4>
            <p class="mb-0">Materias Asignadas</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card stats-card bg-info text-white">
            <i class="fas fa-users fa-2x mb-2"></i>
            <h4><?= esc($estadisticas['total_estudiantes'] ?? 0) ?></h4>
            <p class="mb-0">Estudiantes Inscritos</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card stats-card bg-warning text-dark">
            <i class="fas fa-star fa-2x mb-2"></i>
            <h4><?= esc($estadisticas['promedio_calificaciones'] ?? '-') ?></h4>
            <p class="mb-0">Promedio General</p>
          </div>
        </div>
      </div>

      <!-- MATERIAS DICTADAS -->
      <h3 class="mb-3"><i class="fas fa-book-open me-2"></i>Materias Dictadas</h3>
      <div class="row">
        <?php if (!empty($materias_dictadas)): ?>
          <?php foreach ($materias_dictadas as $materia): ?>
            <div class="col-md-4 mb-4">
              <div class="card materia-card p-3" data-bs-toggle="modal" data-bs-target="#modalMateria<?= esc($materia['id_materia']) ?>">
                <h5 class="mb-1"><?= esc($materia['nombre_materia']) ?></h5>
                <small class="text-muted">Código: <?= esc($materia['codigo_materia']) ?></small>
                <div class="mt-3 text-end">
                  <span class="badge bg-primary">
                    <i class="fas fa-users me-1"></i><?= esc($materia['total_estudiantes'] ?? 0) ?> estudiantes
                  </span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No hay materias dictadas.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- MODALES -->
  <?php if (!empty($estudiantes_por_materia)): ?>
    <?php foreach ($estudiantes_por_materia as $materia_id => $data): ?>
      <div class="modal fade" id="modalMateria<?= esc($materia_id) ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title"><i class="fas fa-users me-2"></i><?= esc($data['materia']['nombre_materia']) ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <?php if (!empty($data['estudiantes'])): ?>
                <ul class="list-group">
                  <?php foreach ($data['estudiantes'] as $est): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <strong><?= esc($est['nombre_estudiante']) ?></strong><br>
                        <small>DNI: <?= esc($est['dni']) ?></small>
                      </div>
                      <span class="badge bg-secondary"><?= esc($est['estado_inscripcion']) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <p class="text-center text-muted m-0">No hay estudiantes inscriptos.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <!-- FOOTER (igual que el tuyo, intacto) -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5><i class="fas fa-university me-2"></i>Instituto Superior 57</h5>
          <p><i class="fas fa-map-marker-alt me-2"></i>Av. Siempre Viva 742, Springfield</p>
          <p><i class="fas fa-phone me-2"></i>+54 11 3456-7890</p>
          <p><i class="fas fa-envelope me-2"></i>info@instituto57.edu.ar</p>
        </div>
        <div class="col-md-6 text-md-end">
          <h5>Formando profesionales desde 1990</h5>
          <p>Excelencia académica e innovación tecnológica</p>
        </div>
      </div>
      <hr class="my-3">
      <div class="text-center">
        <p class="mb-0">&copy; 2025 Gestión Instituto. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
