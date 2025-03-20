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