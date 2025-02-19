<?php

    include_once "function.php";
    include "../header.php";

?>

    <div class="">
        <p>Connexion</p>
        <form action="cadre.php" method="post">
            <div>
                <label for="">Pseudo :</label>
                <input type="text" name="pseudo" size="15">
            </div>
            <div>
                <label for="">Mot de passe :</label>
                <input type="password" name="mdp" size="15">
            </div>
            <input type="submit" value="envoyer" name="connexion"><br/>
        </form>
    </div>

<?php

    include_once "../footer.php";

?>