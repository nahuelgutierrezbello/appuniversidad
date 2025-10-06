<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
            <i class="fas fa-university me-2"></i>
            <span>Instituto Superior 57</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>#about">Quiénes Somos</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#careers" id="navbarDropdownOfertaAcademica" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ofertas Académicas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownOfertaAcademica">
                        <li><a class="dropdown-item" id="ciencia-datos-link" href="javascript:void(0);">Ciencia de Datos e Inteligencia Artificial</a></li>
                        <li><a class="dropdown-item" id="profesorado-matematica-link" href="javascript:void(0);">Profesorado de Matemática</a></li>
                        <li><a class="dropdown-item" id="profesorado-ingles-link" href="javascript:void(0);">Profesorado de Inglés</a></li>
                        <li><a class="dropdown-item" id="educacion-inicial-link" href="javascript:void(0);">Educación Inicial</a></li>
                        <li><a class="dropdown-item" id="enfermeria-link" href="javascript:void(0);">Enfermería</a></li>
                        <li><a class="dropdown-item" id="seguridad-higiene-link" href="javascript:void(0);">Seguridad e Higiene</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>#student-life">Vida Estudiantil</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>#contact">Contacto</a></li>
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
