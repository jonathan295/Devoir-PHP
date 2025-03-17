<?php
include('cadre.php');
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
   <img src="titre_img/affich_devoir.png" class="position_titre">
  </div>
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
$_SESSION['semestre']=$_POST['radiosem'];
$nomcl=$_POST['nomcl'];
$semestre=$_SESSION['semestre'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$_POST['promotion'];
$donnee=mysqli_query($conn, "select nommat from matiere,enseignement,classe where matiere.codemat=enseignement.codemat and enseignement.codecl=classe.codecl and classe.nom='$nomcl' and promotion='$promo' and enseignement.numsem='$semestre'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
$_SESSION['classe']=$nomcl;
?>
<form method="post" action="afficher_devoir.php" class="form">
   <h3 class="text-center">Les matières étudiées par la classe choisis</h3>
   <div class="row m-4 text-center justify-content-center">
      <h3 class="text-center">Matière</h3>
      <?php
      while($a=mysqli_fetch_array($donnee)){
      echo '<input class="col-1" type="radio" name="radio" value="'.$a['nommat'].'" id="choix1" /><label class="col-2" for="choix1">'.$a['nommat'].'</label><br /><br />';
      }
      ?>
   </div>
   <div class="row m-4 text-center justify-content-center">
      <input class="btn btn-dark col-2" type="submit" value="Afficher les devoirs">
   </div>
</form>
<?php
}
else if(isset($_POST['radio'])){
$semestre=$_SESSION['semestre'];
$nommat=$_POST['radio'];
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$donnee=mysqli_query($conn, "select numdev,date_dev,nommat,nom,coeficient,numsem,n_devoir from devoir,matiere,classe where matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and classe.nom='$nomcl' and devoir.numsem='$semestre' and matiere.nommat='$nommat' and promotion='$promo'");
?>
<table class="table table-hover table-striped table-bordered" id="rounded-corner">
<thead><tr><?php echo Edition(); ?><th class="<?php echo rond(); ?>">Matière</th><th class="rounded-q2">Date_devoir</th><th class="rounded-q2">Classe</th><th class="rounded-q2">Coefficient</th><th class="rounded-q2">Semestre</th><th class="rounded-q4">1er/2eme devoir</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(5,7); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){ 
echo '<td><a href="modif_devoir.php?modif_dev='.$a['numdev'].'">modifier</a></td><td><a href="modif_devoir.php?supp_dev='.$a['numdev'].'" onclick="return(confirm(\'Etes-vous s�r de vouloir supprimer cette entr�e?\ntous les enregistrements en relation avec cette entr�e seront perdus\'));">Supprimer</td>';} echo '<td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['nom'].'</td><td>'.$a['coeficient'].'</td><td>S'.$a['numsem'].'</td><td>'.$a['n_devoir'].'</td></tr>';
}
?>
</tbody>
</table>
<a class="btn btn-dark" href="afficher_devoir.php">Revenir à la page principale !</a>
<?php
}//fin   if(isset($_POST['radio']
else {
$retour=mysqli_query($conn, "select distinct nom from classe"); // afficher les classes
?>
<form method="post" action="afficher_devoir.php" class="form">
   <h3 class="text-center">Veuillez choisir le Semestre, la promotion et la classe </h3>
   <div class="row m-4 text-center justify-content-center flex-column align-items-center">
      <label for="">Promotion</label>
      <select class="col-2" name="promotion"> 
      <?php while($a=mysqli_fetch_array($data)){
      echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
      }?></select>
   </div>
   <div class="row m-4 text-center justify-content-center flex-column align-items-center">
      <label for="">Classe</label>
      <select class="col-2" name="nomcl"> 
      <?php while($a=mysqli_fetch_array($retour)){
      echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
      }?></select>
   </div>
   <div class="row m-4 text-center justify-content-center flex-column align-items-center">
      <label for="">Semestre</label>
      <select class="col-2" name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
      </select>
   </div>
   <div class="row m-4 text-center justify-content-center">
      <input class="btn btn-dark col-2" type="submit" value="Afficher les matieres">
   </div>
</form>
<?php } ?>
</div>
</body>
</html>