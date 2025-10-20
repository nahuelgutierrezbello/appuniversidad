<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema - Instituto Superior 57</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(to bottom right, #0d6efd, #3f8efc);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-university fa-3x text-primary mb-3"></i>
                    <h4 class="fw-bold text-primary">Instituto Superior 57</h4>
                    <h6 class="text-muted">Acceso al Sistema</h6>
                </div>

                <!-- Formulario de Login -->
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese su correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" placeholder="Ingrese su contraseña" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="#" id="forgotPassword" class="small text-decoration-none">Olvidate la contraseña, contacta al administrador</a>
                        <button type="submit" class="btn btn-primary px-4">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal contacto administrador -->
<div class="modal fade" id="contactAdminModal" tabindex="-1" aria-labelledby="contactAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="contactAdminLabel"><i class="fas fa-envelope me-2"></i> Contactar al Administrador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="contactAdminForm" method="POST" action="<?= base_url('consultas_admin/crear'); ?>">
                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input type="text" name="asunto" id="asunto" class="form-control" maxlength="80" placeholder="Ej: Recuperación de contraseña" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_usuario" class="form-label">Correo electrónico</label>
                        <input type="email" name="email_usuario" id="email_usuario" class="form-control" placeholder="Tu correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea name="mensaje" id="mensaje" class="form-control" rows="4" maxlength="300" placeholder="Escribe tu consulta aquí..." required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-warning w-100">Enviar consulta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Abrir modal de contacto admin
    document.getElementById('forgotPassword').addEventListener('click', function(e) {
        e.preventDefault();
        new bootstrap.Modal(document.getElementById('contactAdminModal')).show();
    });

    // Simulación de login
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'success',
            title: 'Acceso concedido',
            text: 'Bienvenido al sistema.',
            confirmButtonColor: '#0d6efd'
        });
    });

    // Confirmación de envío de consulta
    document.getElementById('contactAdminForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'success',
            title: 'Consulta enviada',
            text: 'El administrador se comunicará con usted pronto.',
            confirmButtonColor: '#0d6efd'
        }).then(() => {
            this.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('contactAdminModal'));
            modal.hide();
        });
    });
</script>
</body>
</html>
