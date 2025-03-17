<?php
    include "../header.php";
?>

    <div class="container d-flex flex-column align-items-center justify-content-center mt-4 mb-4">
        <span class="font-weight-bold m-2">Connexion</span>
        <form class="formulaire" action="/gestion00/pages/form/traitement/connexion_recup.php" method="post">
            <div class="form-group">
                <label for="type"><span class="font-weight-bold">Êtes vous prof ou étudiant ?</span></label>
                <select name="type" id="type" class="form-select <?php if (!empty($_SESSION["type_err_conn"])) {echo " is-invalid";} ?>">
                    <option selected>Choisir..</option>
                    <option value="etudiant">Etudiant</option>
                    <option value="prof">Professeur</option>
                    <option value="admin">Admin</option>
                    <?php if (!empty($_SESSION["type_err_conn"])): ?>
                        <div id="" class="invalid-feedback">
                            <p><?php echo $_SESSION["type_err_conn"]; ?></p>
                        </div>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group m-4">
                <label for="pseudo"><span class="font-weight-bold">Pseudo :</span></label>
                <input class="form-control <?php if (!empty($_SESSION["pseudo_err_conn"])) {echo " is-invalid";} ?>" type="text" name="pseudo" size="15" id="pseudo">
            <?php if (!empty($_SESSION["pseudo_err_conn"])): ?>
                <div id="" class="invalid-feedback">
                    <p><?php echo $_SESSION["pseudo_err_conn"]; ?></p>
                </div>
            <?php endif; ?>
            </div>
            <div class="form-group m-4">
                <label for="mdp"><span class="font-weight-bold">Mot de passe :</span></label>
                <input class="form-control  <?php if (!empty($_SESSION["password_err_conn"])) {echo " is-invalid";} ?>" type="password" name="mdp" size="15" id="mdp">
                <?php if (!empty($_SESSION["password_err_conn"])): ?>
                <div id="" class="invalid-feedback">
                    <p><?php echo $_SESSION["password_err_conn"]; ?></p>
                </div>
            <?php endif; ?>
            </div>
            <input type="submit" value="envoyer" name="connexion" class="btn-lg"><br/>
        </form>
    </div>

<?php

    include_once "../footer.php";

?>