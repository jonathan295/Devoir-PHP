<?php

include_once "../header.php";

?>

<div class="container mb-4">
      <h3 class="fw-bolder">Inscription</h3>
      <form action="/gestion/pages/form/traitement/inscription_recup.php" class="row g-3" method="POST">
          <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Nom:* </label>
            <input name="nom" type="text" class="form-control <?php if (!empty($_SESSION["nom_err"])) {echo " is-invalid";} ?>" id="inputEmail4" value="<?php if (!empty($_SESSION["nom"])) {echo $_SESSION["nom"];} ?>">
            <?php if (!empty($_SESSION["nom_err"])): ?>
              <div id="" class="invalid-feedback">
                <p><?php echo $_SESSION["nom_err"]; ?></p>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-md-6">
            <label for="inputPrenom4" class="form-label">Prénom(s):*</label>
            <input name="prenom" type="text" class="form-control <?php if (!empty($_SESSION["prenom_err"])) {echo " is-invalid";} ?>" id="inputPrenom4" value="<?php if (!empty($_SESSION["prenom"])) {echo $_SESSION["prenom"];} ?>">
            <?php if (!empty($_SESSION["prenom_err"])): ?>
              <div id="" class="invalid-feedback">
                <p><?php echo $_SESSION["prenom_err"]; ?></p>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email:*</label>
            <input name="email" type="email" class="form-control <?php if (!empty($_SESSION["email_err"])) {echo " is-invalid";} ?>" id="inputEmail4" value="<?php if (!empty($_SESSION["email"])) {echo $_SESSION["email"];} ?>">
            <?php if (!empty($_SESSION["email_err"])): ?>
              <div id="" class="invalid-feedback">
                <p><?php echo $_SESSION["email_err"]; ?></p>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Mot de passe : </label>
              <div class="input-group">
                  <input name="password" type="password" class="form-control <?php if (isset($_SESSION["mdp_err"])) { echo 'is-invalid'; } ?>" id="inputPassword4">
                  <span class="input-group-text">
                    <!-- <img src="/newgestion/pages/eye_icone.png" id="togglePassword" class="bi bi-eye" style="cursor: pointer;"></img> -->
                    <i id="togglePassword" class="bi bi-eye" style="cursor: pointer;"></i>
                  </span>
                  <?php if (isset($_SESSION["mdp_err"])): ?>
                      <div id="validationServerPasswordFeedback" class="invalid-feedback">
                          <p><?php echo $_SESSION["mdp_err"]; ?></p>
                      </div>
                  <?php endif; ?>
              </div>
          </div>

          <div class="col-4">
            <label for="inputtel" class="form-label">Numéro de téléphone:*</label>
            <input name="tel" type="tel" class="form-control <?php if (!empty($_SESSION["tel_err"])) {echo " is-invalid";} ?>" id="inputtel" placeholder="+261:" value="<?php if (!empty($_SESSION["tel"])) {echo $_SESSION["tel"];} ?>">
            <?php if (!empty($_SESSION["tel_err"])): ?>
              <div id="" class="invalid-feedback">
                <p><?php echo $_SESSION["tel_err"]; ?></p>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-8">
            <label for="inputAddress2" class="form-label">Addresse:*</label>
            <input name="adresse" type="text" class="form-control <?php if (!empty($_SESSION["adresse_err"])) {echo " is-invalid";} ?>" id="inputAddress2" placeholder="Apartment, studio, or floor" value="<?php if (!empty($_SESSION["adresse"])) {echo $_SESSION["adresse"];} ?>">
            <?php if (!empty($_SESSION["adresse_err"])): ?>
              <div id="" class="invalid-feedback">
                <p><?php echo $_SESSION["adresse_err"]; ?></p>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-md-6">
            <label for="inputCity" class="form-label">Ville:</label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-4">
            <label for="inputState" class="form-label">Sexe:</label>
            <select name="genre" id="inputState" class="form-select">
              <option selected>Choose...</option>
              <option value="M">Homme</option>
              <option value="F">Femme</option>
            </select>
          </div>
          <div class="col-md-2">
            <label for="inputZip" class="form-label">Profil:</label>
            <input name="pdp" type="file" class="form-control" id="inputZip">
          </div>
          <div class="col-4">
            <label for="type" class="form-label">Êtes vous étudiant ou professeur ?:*</label>
            <select name="type" class="form-select <?php if (!empty($_SESSION["type_err"])) {echo " is-invalid";} ?>" id="type">
              <option selected>Choose...</option>
              <option value="prof">Professeur</option>
              <option value="etudiant">Etudiant</option>
            </select>
            <?php if (!empty($_SESSION["type_err"])): ?>
              <div id="" class="invalid-feedback">
                <p><?php echo $_SESSION["type_err"]; ?></p>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-4">
            <label for="date_naissance" class="form-label">Date de naissance :*</label>
            <input class="form-control <?php if (!empty($_SESSION["date_naissance_err"])) {echo " is-invalid";} ?>" type="date" name="date_naissance" placeholder="18/04/2005" id="date_naissance">
            <?php if (!empty($_SESSION["date_naissance_err"])): ?>
              <div id="" class="invalid-feedback">
                <p><?php echo $_SESSION["date_naissance_err"]; ?></p>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary" name="inscription">Sign in</button>
          </div>
      </form>
  </div>

<?php

include_once "../footer.php";

?>
</body>
</html>