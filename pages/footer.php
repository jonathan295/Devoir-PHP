</div>
<!-- FOOTER -->
<footer class="text-center text-lg-start mt-4">
    <div class="container-fluid p-4">
      <div class="row">
        <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
            <h5 class="text-uppercase pb-3">À propos de nous</h5>
            <p>
            INSI , propose de formation modulaire, professionnel    pour vous aidez à votre insertion professionnel dans le domaine du développement web, administration réseaux et systèmes, intelligence artificielle , data science, data analytics, data visualisation, data engineer, machine learning, deep learning, python et langage R .
            </p>
        </div>
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0 border-start border-end border-1">
          <h5 class="text-uppercase text-center pb-3">Liens</h5>
          <ul class="d-flex justify-content-center align-items-center list-unstyled mb-0">
            <li class="d-flex justify-content-center align-items-center me-1" style="width: 20px;">
              <a href="/gestion/index.php" class="d-flex justify-content-center align-items-center"><img src="/gestion/image/home.png" class="object-fit-contain w-100 h-100" alt=""></a>
            </li>
            <li class="text-center">
              <a href="/gestion/index.php" class="text-white text-decoration-none">Revenir à l'acceuil</a>
            </li>
          </ul>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase pb-3">Contact</h5>
          <ul class="list-unstyled mb-0">
            <li>
              <p>Adresse : Madagascar, Antananrivo, localisé dans le quartier de Ambanidia</p>
            </li>
            <li>
              <p>Téléphone : +1 234 567 890</p>
            </li>
            <li>
              <a href="mailto:mambajonathan3@gmail.com" class="fwt-italic">Email : mambajonathan3@gmail.com</a>
            </li>
          </ul>
        </div>
        
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2025 Copyright:
      <a class="text-white fw-bold fst-italic" href="https://example.com/">feru.com</a>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#inputPassword4');
    
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('nav');

        let scrollY = window.scrollY;

        if (scrollY > 0) {
            nav.style.opacity = "0.8";
            nav.style.padding = "0px";
            nav.addEventListener('mouseover', function() {
                if (nav.style.opacity = "0.8") {
                    nav.style.opacity = "1";
                } else {
                    nav.style.opacity = "1";
                }
            });
            nav.addEventListener('mouseout', function() {
                if (nav.style.opacity = "1") {
                    nav.style.opacity = "0.8";
                } else {
                    nav.style.opacity = "0.8";
                }
            });
        }else {
            nav.style.opacity = "1";
            nav.style.padding = "0.3125rem";
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