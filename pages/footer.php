</div>
<!-- FOOTER -->
        <footer class="footer fw-lighter pb-4 mt-4">
            <div class="container pt-4">
                <div class="row text-start">
                    <!-- Colonne 1 : À propos -->
                    <div class="col-md-4">
                        <h5 class="text-white">À propos</h5>
                        <p class="text-white">Ce site permet de gérer les étudiants, enseignants et les matières de manière efficace.</p>
                    </div>

                    <!-- Colonne 2 : Liens utiles -->
                    <div class="col-md-4">
                        <h5 class="text-white">Liens utiles</h5>
                        <ul class="list-unstyled lh-1">
                            <li><a class="nav-link text-start fw-lighter" href="#">Accueil</a></li>
                            <li><a class="nav-link text-start fw-lighter" href="#">Services</a></li>
                            <li><a class="nav-link text-start fw-lighter" href="#">Contact</a></li>
                            <li><a class="nav-link text-start fw-lighter" href="#">Mentions légales</a></li>
                        </ul>
                    </div>

                    <!-- Colonne 3 : Contact -->
                    <div class="col-md-4 lh-1">
                        <h5 class="text-white">Contact</h5>
                        <p class="text-white">Email : contact@site.com</p>
                        <p class="text-white">Téléphone : +261 34 00 000 00</p>
                    </div>
                </div>
            </div>

            <!-- Bas de page -->
            <div class="footer-bottom">
                <p class="text-center mb-0 text-white">&copy; 2025 - Tous droits réservés</p>
            </div>
        </footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#inputPassword4');
    console.log("oui");
    

    window.addEventListener('scroll', function() {
        var element = document.querySelector('.with-bg'); // Remplacez 'monElement'
        var scrollY = window.scrollY; // Position de défilement verticale
        var navbar = document.querySelector('.navbar');
        
        element.style.transition = "height 0.3s ease, opacity 0.3s ease, margin 0.3s ease";

        if (scrollY > 10) {
            element.style.height = "inherit";
            element.style.margin = "1.5rem !important";
            element.style.opacity = "0.8";
        } else {
            element.style.height = "200px";
            element.style.opacity = "1";

            navbar.addEventListener('mouseover', function() {
                element.style.opacity = "1";
            });
        }
    });

    togglePassword.addEventListener('click', function (e) {
        // bascule l'attribut type de l'input
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // bascule l'icône
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>

</html>