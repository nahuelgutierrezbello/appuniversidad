<!-- app/Views/Dashboard_Estudiantes/partials/materias_inscritas_card.php -->
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Materias Inscritas</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($materias_inscritas)): ?>
            <div class="list-group">
                <?php foreach ($materias_inscritas as $inscripcion): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><?= esc($inscripcion['nombre_materia']) ?></h6>
                            <small class="text-muted">Inscripción: <?= esc($inscripcion['fecha_inscripcion']) ?></small>
                        </div>
                        <p class="mb-1 small text-muted">Código: <?= esc($inscripcion['codigo_materia']) ?> | Estado: <?= esc($inscripcion['estado_inscripcion'] ?? 'Confirmada') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">No hay materias inscritas.</p>
        <?php endif; ?>
    </div>
</div>