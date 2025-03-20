<?php
    include "../header.php";
?>

<div class="modal modal-sheet position-static d-block">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0 w-100">
                <h1 class="fw-bold mb-0 fs-2 text-center">Se connecter</h1>
            </div>

            <div class="modal-body p-5 pt-0">
                <form class="formulaire" action="/gestion/pages/form/traitement/connexion_recup.php" method="post">
                    <div class="form-group mb-3">
                        <label for="type"><span class="font-weight-bold">Êtes vous prof ou étudiant ?</span></label>
                        <select name="type" id="type" class="form-select <?php if (!empty($_SESSION["type_err_conn"])) {echo " is-invalid";} ?>">
                            <option selected>Choisir..</option>
                            <option value="etudiant">Etudiant</option>
                            <option value="prof">Professeur</option>
                            <option value="admin">Admin</option>
                        </select>
                        <?php if (!empty($_SESSION["type_err_conn"])): ?>
                            <div id="" class="invalid-feedback">
                                <p><?php echo $_SESSION["type_err_conn"]; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="pseudo"><span class="font-weight-bold">Pseudo (Votre prenom lors de l'inscription) :</span></label>
                        <input class="form-control <?php if (!empty($_SESSION["pseudo_err_conn"])) {echo " is-invalid";} ?>" type="text" name="pseudo" size="15" id="pseudo">
                        <?php if (!empty($_SESSION["pseudo_err_conn"])): ?>
                            <div id="" class="invalid-feedback">
                                <p><?php echo $_SESSION["pseudo_err_conn"]; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="mdp"><span class="font-weight-bold">Mot de passe :</span></label>
                        <input class="form-control <?php if (!empty($_SESSION["password_err_conn"])) {echo " is-invalid";} ?>" type="password" name="mdp" size="15" id="mdp">
                        <?php if (!empty($_SESSION["password_err_conn"])): ?>
                            <div id="" class="invalid-feedback">
                                <p><?php echo $_SESSION["password_err_conn"]; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="connexion">Se connecter</button>
                    <small class="text-body-secondary">En cliquant sur Se connecter, vous acceptez les conditions d'utilisation.</small>
                    <hr class="my-4">
                </form>
            </div>
        </div>
    </div>
</div>

<?php

    include_once "../footer.php";

?>