<?php

    session_start();
    // Connexion à la base de donnée
    include_once "pages/controller/config.php";
    // inclusion aux fonctions
    include_once "pages/controller/function.php";

?>

<!-- Mise en place du contenue -->
    <?php
        include_once "pages/controller/function.php";
        include_once "pages/header.php";
        include_once "pages/footer.php";
    ?>
</body>
</html>