<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#inputPassword4');

    togglePassword.addEventListener('click', function (e) {
        // bascule l'attribut type de l'input
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // bascule l'icône
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>