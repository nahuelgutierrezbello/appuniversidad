
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instituto Profesional Modelo - Tu Futuro Comienza Aquí</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('styles.css'); ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <i class="fas fa-university me-2"></i>
                Instituto Superior 57
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Quiénes Somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#careers">Carreras</a></li>
                    <li class="nav-item"><a class="nav-link" href="#student-life">Vida Estudiantil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAcceso" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sign-in-alt me-1"></i> Acceso
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAcceso">
                            <li><a class="dropdown-item" href="<?= base_url('estudiantes'); ?>">Estudiantes</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('registrarCarrera'); ?>">Profesores</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <header class="bg-dark text-white py-5" id="instituto">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">JUANA MANSO</h1>
            <p class="lead">Sistema de Gestión Académica Integral</p>
        </div>
    </header>

    <main>
        <section id="about" class="py-5 bg-light-gray">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h2 class="display-5 fw-bold mb-4 text-primary">Quiénes Somos</h2>
                        <p class="lead">En el Instituto Profesional Modelo, nos dedicamos a formar profesionales con una sólida base académica y habilidades prácticas, listos para enfrentar los desafíos del mercado laboral actual.</p>
                        <p class="text-muted">Nuestra misión es empoderar a nuestros estudiantes a través de programas educativos innovadores, un cuerpo docente de excelencia y un compromiso inquebrantable con el desarrollo personal y profesional. Creemos firmemente en el poder de la educación para transformar vidas y construir un futuro mejor.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Educación de vanguardia</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Docentes experimentados</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Enfoque práctico y orientado al empleo</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Tecnología y recursos modernos</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img src="<?= base_url('img/34.gif'); ?>" class="img-fluid rounded shadow-lg" alt="Imagen sobre nosotros">
                    </div>
                </div>
            </div>
        </section>
        
        <section id="careers" class="py-5">
            <div class="container">
                <h2 class="display-5 fw-bold text-center mb-5 text-primary">Nuestra Oferta Académica</h2>
                <p class="text-center lead mb-5 text-muted">Descubre las carreras que te prepararán para el éxito en el mercado laboral.</p>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 career-card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">📲 Diseño Gráfico</h5>
                                <p class="card-text text-muted">Aprende a comunicar ideas visualmente y a crear impacto en diversos medios.</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center">
                                <a href="#" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 career-card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">💻 Programación Web Full Stack</h5>
                                <p class="card-text text-muted">Domina el desarrollo frontend y backend para construir aplicaciones robustas.</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center">
                                <a href="#" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 career-card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">💱 Marketing Digital y Redes Sociales</h5>
                                <p class="card-text text-muted">Conviértete en un experto en estrategias de marketing digital y gestión de comunidades.</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center">
                                <a href="#" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 career-card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">🔏 Ciberseguridad</h5>
                                <p class="card-text text-muted">Protege sistemas y redes de amenazas digitales, un campo en constante crecimiento.</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center">
                                <a href="#" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 career-card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">📊 Análisis de Datos y Big Data</h5>
                                <p class="card-text text-muted">Transforma datos en información valiosa para la toma de decisiones estratégicas.</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center">
                                <a href="#" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 career-card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary">🎮 Desarrollo de Videojuegos</h5>
                                <p class="card-text text-muted">Crea mundos interactivos y experiencias inmersivas desde cero.</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center">
                                <a href="#" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="student-life" class="py-5 bg-secondary-subtle">
            <div class="container">
                <h2 class="display-5 fw-bold text-center mb-5 text-secondary">Vida Estudiantil</h2>
                <p class="text-center lead mb-5 text-muted">Más allá del aula, un ambiente vibrante para crecer, conectar y prosperar.</p>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 student-life-card">
                            <div class="card-body text-center">
                                <i class="fas fa-handshake fa-3x mb-3 text-info"></i>
                                <h5 class="card-title fw-bold text-secondary">Clubes y Organizaciones</h5>
                                <p class="card-text text-muted">Únete a grupos de interés, desarrolla tus pasiones y haz nuevos amigos.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 student-life-card">
                            <div class="card-body text-center">
                                <i class="fas fa-laptop-code fa-3x mb-3 text-info"></i>
                                <h5 class="card-title fw-bold text-secondary">Talleres y Seminarios</h5>
                                <p class="card-text text-muted">Amplía tus conocimientos con actividades extracurriculares y profesionales.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 student-life-card">
                            <div class="card-body text-center">
                                <i class="fas fa-dumbbell fa-3x mb-3 text-info"></i>
                                <h5 class="card-title fw-bold text-secondary">Deportes y Actividades Físicas</h5>
                                <p class="card-text text-muted">Mantente activo y forma parte de nuestros equipos deportivos.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 student-life-card">
                            <div class="card-body text-center">
                                <i class="fas fa-users-cog fa-3x mb-3 text-info"></i>
                                <h5 class="card-title fw-bold text-secondary">Servicios de Apoyo al Estudiante</h5>
                                <p class="card-text text-muted">Accede a tutorías, orientación vocacional y apoyo psicológico.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 student-life-card">
                            <div class="card-body text-center">
                                <i class="fas fa-briefcase fa-3x mb-3 text-info"></i>
                                <h5 class="card-title fw-bold text-secondary">Bolsa de Empleo y Prácticas</h5>
                                <p class="card-text text-muted">Conectamos tu talento con oportunidades laborales y de pasantías.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 student-life-card">
                            <div class="card-body text-center">
                                <i class="fas fa-globe fa-3x mb-3 text-info"></i>
                                <h5 class="card-title fw-bold text-secondary">Intercambios Internacionales</h5>
                                <p class="card-text text-muted">Vive una experiencia global y enriquece tu formación académica.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="students-access" class="py-5 bg-primary-subtle d-none">
            <div class="container">
                <h2 class="display-5 fw-bold text-center mb-5 text-primary">Portal de Alumnos</h2>
                <p class="text-center lead mb-5 text-muted">Accede a tus calificaciones, material de estudio y calendario académico.</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 student-portal-card">
                            <div class="card-body text-center">
                                <i class="fas fa-graduation-cap fa-3x mb-3 text-primary"></i>
                                <h5 class="card-title text-secondary fw-bold">Mis Calificaciones</h5>
                                <p class="card-text text-muted">Consulta tu historial académico y el progreso de tus cursos.</p>
                                <a href="#" class="btn btn-outline-primary btn-sm mt-2">Ver Calificaciones</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 student-portal-card">
                            <div class="card-body text-center">
                                <i class="fas fa-book-open fa-3x mb-3 text-danger"></i>
                                <h5 class="card-title text-secondary fw-bold">Material de Estudio</h5>
                                <p class="card-text text-muted">Accede a apuntes, lecturas y recursos complementarios de tus materias.</p>
                                <a href="#" class="btn btn-outline-danger btn-sm mt-2">Acceder Material</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 student-portal-card">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-alt fa-3x mb-3 text-success"></i>
                                <h5 class="card-title text-secondary fw-bold">Calendario Académico</h5>
                                <p class="card-text text-muted">Mantente al tanto de fechas importantes, exámenes y eventos.</p>
                                <a href="#" class="btn btn-outline-success btn-sm mt-2">Ver Calendario</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button class="btn btn-secondary" onclick="window.location.href='#general-access'">Volver al Acceso General</button>
                    </div>
                </div>
            </div>
        </section>

        <section id="admin-access" class="py-5 bg-secondary-subtle d-none">
            <div class="container">
                <h2 class="display-5 fw-bold text-center mb-5 text-secondary">Panel de Administración</h2>
                <p class="text-center lead mb-5 text-muted">Gestiona el instituto eficientemente con estas herramientas administrativas.</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 admin-portal-card">
                            <div class="card-body text-center">
                                <i class="fas fa-user-tie fa-3x mb-3 text-secondary"></i>
                                <h5 class="card-title text-secondary fw-bold">Gestión de Profesores</h5>
                                <p class="card-text text-muted">Administra datos y horarios de los docentes del instituto.</p>
                                <a href="#" class="btn btn-outline-secondary btn-sm mt-2">Acceder</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 admin-portal-card">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x mb-3 text-secondary"></i>
                                <h5 class="card-title text-secondary fw-bold">Gestión de Estudiantes</h5>
                                <p class="card-text text-muted">Controla matrículas, asistencias y rendimiento académico.</p>
                                <a href="#" class="btn btn-outline-secondary btn-sm mt-2">Acceder</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 admin-portal-card">
                            <div class="card-body text-center">
                                <i class="fas fa-book fa-3x mb-3 text-secondary"></i>
                                <h5 class="card-title text-secondary fw-bold">Gestión de Cursos</h5>
                                <p class="card-text text-muted">Crea y actualiza cursos, asignaturas y horarios de clases.</p>
                                <a href="#" class="btn btn-outline-secondary btn-sm mt-2">Acceder</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button class="btn btn-secondary" onclick="window.location.href='#general-access'">Volver al Acceso General</button>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-5 bg-light-gray">
            <div class="container">
                <h2 class="display-5 fw-bold text-center mb-5 text-primary">Contáctanos</h2>
                <div class="row">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h4 class="fw-bold mb-3">Envíanos un Mensaje</h4>
                        <form>
                            <div class="mb-3">
                                <label for="contactName" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="contactName" placeholder="Tu Nombre">
                            </div>
                            <div class="mb-3">
                                <label for="contactEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="contactEmail" placeholder="tu.email@ejemplo.com">
                            </div>
                            <div class="mb-3">
                                <label for="contactSubject" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="contactSubject" placeholder="Motivo de tu consulta">
                            </div>
                            <div class="mb-3">
                                <label for="contactMessage" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="contactMessage" rows="5" placeholder="Escribe tu mensaje aquí..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Enviar Mensaje</button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">Encuéntranos</h4>
                        <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i> Calle Ficticia 123, Ciudad Ejemplo, Provincia XYZ</p>
                        <p class="text-muted"><i class="fas fa-phone me-2"></i> +54 9 11 1234-5678</p>
                        <p class="text-muted"><i class="fas fa-envelope me-2"></i> info@tuinstituto.com</p>
                        <div class="map-container mb-4 rounded shadow-sm">
                            <iframe src="https://www.google.com/maps/embed?pb=!4v1748301775086!6m8!1m7!1sSdL67OYbaIRBjxlWJP07cw!2m2!1d-35.57365481103263!2d-58.01375203290051!3f351.2763313649954!4f-8.335368344541308!5f0.7820865974627469" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="social-links text-center text-lg-start">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                    <h5><i class="fas fa-university me-2"></i>Instituto Superior 57</h5>
                    <p class="mb-0">Formando profesionales desde 1990</p>
                </div>
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <ul class="list-unstyled d-inline-flex mb-0">
                        <li class="mx-2"><a href="#about" class="text-white text-decoration-none small">Quiénes Somos</a></li>
                        <li class="mx-2"><a href="#careers" class="text-white text-decoration-none small">Oferta Académica</a></li>
                        <li class="mx-2"><a href="#" class="text-white text-decoration-none small">Política de Privacidad</a></li>
                    </ul>
                </div>
                <div class="col-md-4 text-center text-md-end mb-3 mb-md-0">
                    <h5>Contacto</h5>
                    <p class="mb-1"><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                    <p class="mb-0"><i class="fas fa-envelope me-2"></i> info@instituto.edu</p>
                </div>
            </div>
            <hr class="my-3" />
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">© 2023 Gestión Instituto. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <a href="https://wa.me/5491112345678" class="whatsapp-float whatsapp-right" target="_blank" rel="noopener noreferrer">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('app.js'); ?>"></script>
</body>
</html>
