<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnicatura Superior en Ciencia de Datos e IA - Instituto Superior 57</title>
    <meta name="description" content="Tecnicatura Superior en Ciencia de Datos e Inteligencia Artificial - 3 años - Resolución 2730/22. Formación integral para profesionales del futuro.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- AOS Library (Animaciones) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6610f2;
            --accent-color: #20c997;
            --dark-color: #212529;
            --light-color: #f8f9fa;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
        
        /* Hero Section */
        .hero-career {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.9), rgba(102, 16, 242, 0.9)), url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
            color: white;
            padding: 120px 0 100px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-career::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }
        
        .section-title:hover:after {
            width: 100px;
        }
        
        .section-title.center:after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* Cards */
        .card-career {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            overflow: hidden;
        }
        
        .card-career:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }
        
        .card-career:hover .feature-icon {
            transform: scale(1.1);
        }
        
        /* Curriculum */
        .curriculum-item {
            border-left: 3px solid var(--primary-color);
            padding-left: 1.5rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        
        .curriculum-item:hover {
            border-left-width: 5px;
            padding-left: 1.8rem;
        }
        
        /* Badges */
        .badge-career {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }
        
        /* Highlights */
        .career-highlight {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 12px;
            padding: 2.5rem;
            margin: 2rem 0;
            border-left: 5px solid var(--accent-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        /* Stats */
        .stats-counter {
            text-align: center;
            padding: 2rem 1rem;
            transition: transform 0.3s ease;
        }
        
        .stats-counter:hover {
            transform: translateY(-5px);
        }
        
        .stats-counter .number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
            line-height: 1;
        }
        
        .stats-counter .label {
            font-size: 1.1rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin: 1rem 0;
            border-top: 4px solid var(--primary-color);
            transition: transform 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
        }
        
        .testimonial-text {
            font-style: italic;
            color: #555;
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 1.5rem;
        }
        
        .testimonial-text::before {
            content: '"';
            font-size: 4rem;
            color: var(--primary-color);
            opacity: 0.2;
            position: absolute;
            left: -10px;
            top: -20px;
            font-family: serif;
        }
        
        .testimonial-author {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
            opacity: 0.1;
            z-index: 1;
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
        }
        
        /* Floating WhatsApp */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 25px;
            right: 25px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.5);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .whatsapp-float:hover {
            background-color: #128C7E;
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.7);
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }
        
        /* Image enhancements */
        .img-enhanced {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .img-enhanced:hover {
            transform: scale(1.02);
        }
        
        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 90px;
            right: 25px;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 99;
        }
        
        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }
        
        /* Progress bar */
        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: transparent;
            z-index: 1000;
        }
        
        .progress-bar {
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            width: 0%;
            transition: width 0.3s ease;
        }

        /* Estilo para feedback visual durante la carga AJAX */
        .loading-content {
            background-color: #f0f2f5 !important; /* Un gris claro para indicar que algo está pasando */
            min-height: 300px; /* Evita que el contenedor colapse mientras carga */
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Progress Bar -->
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>
    
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
                <i class="fas fa-university me-2"></i>
                <span>Instituto Superior 57</span>
            </a>
            <span class="navbar-text ms-3 fw-bold">Ciencia de datos</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>#about">Quiénes Somos</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownCarreras" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Carreras
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownCarreras">
                            <li><a class="dropdown-item" id="ciencia-datos-link" href="#">Ciencia de Datos</a></li>
                            <li><a class="dropdown-item" id="programacion-web-link" href="#">Programación Web Full Stack</a></li>
                            <li><a class="dropdown-item" href="#careers">Marketing Digital y Redes Sociales</a></li>
                            <li><a class="dropdown-item" href="#careers">Ciberseguridad</a></li>
                            <li><a class="dropdown-item" href="#careers">Análisis de Datos y Big Data</a></li>
                            <li><a class="dropdown-item" href="#careers">Desarrollo de Videojuegos</a></li>
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