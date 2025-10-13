<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vista Estática de Administradores - Instituto Superior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <?= view('templates/NavbarAdmin') ?>
    <header class="bg-dark text-white py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Vista Estática de Administradores</h1>
            <p class="lead">Esta es una versión estática para mostrar la vista sin conexión a base de datos.</p>
        </div>
    </header>
    <main class="container my-5">
        <section class="row justify-content-center mb-5">
            <div class="col-lg-9">
                <div class="card shadow">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0"><i class="fas fa-user-plus me-2"></i> Registrar Nuevo Administrador</h2>
                    </div>
                    <div class="card-body">
                        <form id="adminForm" method="post" action="#">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="name" name="nadmin" required disabled />
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" pattern="\d{8}" maxlength="8" required disabled />
                                <small class="text-muted">Debe tener 8 dígitos</small>
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Edad</label>
                                <input type="text" class="form-control" id="age" name="edad" maxlength="2" required disabled />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required disabled />
                            </div>
                            <div class="mb-3">
                                <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" disabled />
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success" disabled>
                                    <i class="fas fa-save me-1"></i> Registrar Administrador
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <div class="row justify-content-center mt-5">
            <div class="col-9">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0"><i class="fas fa-list me-2"></i> Listado de Administradores (Estático)</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="adminsTable" class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>DNI</th>
                                        <th>Edad</th>
                                        <th>Email</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Juan Pérez</td>
                                        <td>12345678</td>
                                        <td>35</td>
                                        <td>juan.perez@example.com</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" disabled>
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" disabled>
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>María Gómez</td>
                                        <td>87654321</td>
                                        <td>29</td>
                                        <td>maria.gomez@example.com</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" disabled>
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" disabled>
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2023 Gestión Instituto. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
