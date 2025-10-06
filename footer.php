    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5 class="mb-3">Instituto Superior 57</h5>
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Av. Siempre Viva 742, Springfield</p>
                    <p class="mb-2"><i class="fas fa-phone me-2"></i>+54 11 3456-7890</p>
                    <p class="mb-0"><i class="fas fa-envelope me-2"></i>info@instituto57.edu.ar</p>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <h5 class="mb-3">Enlaces rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url(); ?>" class="text-white-50 text-decoration-none">Inicio</a></li>
                        <li class="mb-2"><a href="<?= base_url(); ?>#about" class="text-white-50 text-decoration-none">Quiénes Somos</a></li>
                        <li class="mb-2"><a href="<?= base_url(); ?>#careers" class="text-white-50 text-decoration-none">Carreras</a></li>
                        <li><a href="<?= base_url(); ?>#contact" class="text-white-50 text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="mb-3">Seguinos</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white-50"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 small">&copy; 2023 Instituto Superior 57. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 small"><a href="#" class="text-white-50 text-decoration-none">Política de privacidad</a> | <a href="#" class="text-white-50 text-decoration-none">Términos y condiciones</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/5491134567890?text=Hola,%20me%20interesa%20la%20Tecnicatura%20en%20Ciencia%20de%20Datos%20e%20IA" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <!-- AOS Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Inicializar AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
        
        // Back to top button
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            // Mostrar/ocultar botón de volver arriba
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('active');
            } else {
                backToTopButton.classList.remove('active');
            }
            
            // Actualizar barra de progreso
            updateProgressBar();
        });
        
        // Función para actualizar la barra de progreso
        function updateProgressBar() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
        }
        
        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Efecto de escritura para el título principal
        const titleElement = document.querySelector('.hero-career h1');
        if (titleElement) {
            const originalText = titleElement.textContent;
            titleElement.textContent = '';
            
            let i = 0;
            const typeWriter = () => {
                if (i < originalText.length) {
                    titleElement.textContent += originalText.charAt(i);
                    i++;
                    setTimeout(typeWriter, 50);
                }
            };
            
            // Iniciar efecto después de un breve retraso
            setTimeout(typeWriter, 500);
        }
    </script>
</body>
</html>