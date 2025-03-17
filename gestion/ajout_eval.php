<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
   <div class="container d-flex align-items- justify-content-center">
      <img src="titre_img/ajout_eval.png" class="position_titre">
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
<form method="post" action="ajout_eval.php" class="form">
   <h3 class="text-center">Veuillez choisir la matière</h3>
   <div class="row justify-content-center m-4 text-center ">
      <?php
      $i=6;
      while($a=mysqli_fetch_array($donnee)){
         echo '<input class="col-1" type="radio" name="radio" value="'.$a['nommat'].'" id="choix'.$i.'" /> <label class="col-2" for="choix'.$i.'">'.$a['nommat'].'</label><br /><br />';
         $i++;
      }
      ?>
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <input class="btn btn-dark col-2" type="submit" value="Afficher les devoirs">
   </div>
</form>
<?php
}
else if(isset($_POST['radio'])){
$semestre=$_SESSION['semestre'];
$nommat=$_POST['radio'];
$_SESSION['radio_matiere']=$nommat;
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$donnee=mysqli_query($conn, "select numdev,date_dev,nommat,nom,coeficient,numsem,n_devoir from devoir,matiere,classe where matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and classe.nom='$nomcl' and devoir.numsem='$semestre' and matiere.nommat='$nommat' and promotion='$promo'");
?>
<table class="table table-hover table-striped table-bordered" id="rounded-corner">
<thead><tr><th scope="col" class="rounded-company">Evaluation</th><th scope="col" class="rounded-q1">Matière</th><th scope="col" class="rounded-q2">Date devoir</th><th scope="col" class="rounded-q3">Classe</th><th scope="col" class="rounded-q3">Coefficient</th><th scope="col" class="rounded-q3">Semestre</th><th scope="col" class="rounded-q4">1er/2eme devoir</th></tr></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
echo '<td><a href="ajout_eval.php?ajout_eval='.$a['numdev'].'">Ajouter evaluation</a></td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['nom'].'</td><td>'.$a['coeficient'].'</td><td>S'.$a['numsem'].'</td><td>'.$a['n_devoir'].'</td></tr>';
}
?>
</tbody>
<tr></tr>
</table>
<a class="btn btn-dark" href="ajout_eval.php">Revenir à la page principale !</a>
<?php
}//fin   if(isset($_POST['radio']
else if(isset($_POST['numel'])){ // l'insertion, on recupere le numel et la note avec les autres session et on insert
$numel=$_POST['numel'];
$numdev=$_POST['numdev'];
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$note=str_replace(",",".",$_POST['note']);//replacer les , par . car c double
/*$codecl=mysqli_fetch_array(mysqli_query($conn, "select codecl from classe where nom='$nomcl' and promotion='$promo'"));
$codecl=$codecl['codecl'];*/
$compte=mysqli_fetch_array(mysqli_query($conn, "select count(*) as nb from evaluation where numdev='$numdev' and numel='$numel'"));//pour ne pas repeter le meme enregistrement
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">
alert("erreur d\'insertion, l\'enregistrement existe deja !");
</SCRIPT>
<a class="btn btn-dark" href="ajout_eval.php">Revenir à la page principale </a>
<?php
}
else{
mysqli_query($conn, "insert into evaluation(numdev,numel,note) values('$numdev','$numel','$note')");
?>
<SCRIPT LANGUAGE="Javascript">
alert("Ajout avec succès!");
</SCRIPT>
<br/><br/><a href="ajout_eval.php">Revenir à la page principale </a>
<?php
}
}
else if(isset($_GET['ajout_eval'])){// si on a cliquer sur voir l'evaluation d'un devoir
$semestre=$_SESSION['semestre'];
$nommat=$_SESSION['radio_matiere'];
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$numdev=$_GET['ajout_eval'];
$donnee=mysqli_fetch_array(mysqli_query($conn, "select date_dev,coeficient,n_devoir from devoir where numdev='$numdev'"));//  pour afficher les information du devoir k'il a choisis pour ajouter un devoir
$data=mysqli_query($conn, "select numel,nomel,prenomel from eleve where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo')");//pour afficher les etudiants
?>
<form method="POST" action="ajout_eval.php" class="formulaire">
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Filière</label>
      <input type="text" value="<?php echo $nomcl.' - '.$promo; ?>">
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Matière</label>
      <input type="text" value="<?php echo $nommat; ?>">
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Semestre</label>
      <input type="text" value="<?php echo $semestre; ?>">
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Date devoir</label>
      <input type="text" value="<?php echo $donnee['date_dev']; ?>">
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Coefficient</label>
      <input type="text" value="<?php echo $donnee['coeficient']; ?>">
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Devoir N°</label>
      <input type="text" value="<?php echo $donnee['n_devoir']; ?>">
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Etudiant</label>
      <select class="col-2" name="numel"> 
      <?php while($a=mysqli_fetch_array($data)){
      echo '<option value="'.$a['numel'].'">'.$a['nomel'].' '.$a['prenomel'].'</option>';
      }?></select>
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Note</label>
      <input type="text" name="note">
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <input type="hidden" name="numdev" value="<?php echo $numdev; ?>">
   </div>
   <div class="row justify-content-center m-4 text-center">
      <input class="btn btn-dark col-2" type="submit" value="Ajouter">
   </div>
</form>
<a class="btn btn-dark" href="ajout_eval.php">Revenir à la page principale !</a>
<?php }
else {
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
?>
<h3 class="text-center">Veuillez choisir le Semestre, la promotion et la classe :</h3>
<form method="post" action="ajout_eval.php" class="form">
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Promotion</label>
      <select class="col-2" name="promotion"> 
      <?php while($a=mysqli_fetch_array($data)){
      echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
      }?></select>
   </div>
<?php $data=mysqli_query($conn, "select distinct nom from classe"); ?>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Classe</label>
      <select class="col-2" name="nomcl"> 
      <?php while($a=mysqli_fetch_array($data)){
      echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
      }?></select>
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label for="">Semestre</label>
      <select class="col-2" name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
      </select>
   </div>
   <div class="row justify-content-center m-4 text-center">
      <input class="btn btn-dark col-2" type="submit" value="Afficher les matieres">
   </div>
</form>
<?php } ?>
</div>
</body>
</html>