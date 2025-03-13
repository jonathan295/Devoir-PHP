<?php
include('cadre.php');
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/affich_note.png" class="position_titre">
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
<form method="post" action="afficher_evaluation.php" class="form">
  <h3 class="text-center">Les matières correspondantes</h3>
  <div class="row justify-content-center m-4 text-center">
  <?php
   $i=6;
   while($a=mysqli_fetch_array($donnee)){
		echo '<input class="col-1" type="radio" name="radio" value="'.$a['nommat'].'" id="choix'.$i.'" /> 
    <label class="col-2" for="choix'.$i.'">'.$a['nommat'].'</label> ';
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
<h3 class="text-center">Veuilliez choisir le devoir pour lequel vous voulez voir l'evalution</h3>
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
echo '<td><a href="afficher_evaluation.php?affich_eval='.$a['numdev'].'">Voir l\'evaluation</a></td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['nom'].'</td><td>'.$a['coeficient'].'</td><td>S'.$a['numsem'].'</td><td>'.$a['n_devoir'].'</td></tr>';
}
?>
 </tbody>
</table>
<a class="btn btn-dark" href="afficher_evaluation.php">Revenir à la page principale !</a>
<?php
}//fin   if(isset($_POST['radio']
else if(isset($_GET['affich_eval'])){// si on a cliquer sur voir l'evaluation d'un devoir
//$semestre=$_SESSION['semestre'];
//$nommat=$_SESSION['radio_matiere'];
//$nomcl=$_SESSION['classe'];
//$promo=$_SESSION['promo'];
$numdev=$_GET['affich_eval'];
$donnee=mysqli_query($conn, "select numeval,date_dev,nommat,nom,nomel,prenomel,note,coeficient,numsem,promotion,n_devoir from devoir,matiere,classe,eleve,evaluation where evaluation.numdev=devoir.numdev and eleve.numel=evaluation.numel and matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and devoir.numdev='$numdev'");//  and matiere.nommat='$nommat'      and devoir.numsem='$semestre'
?>
<table class="table table-hover table-striped table-bordered" id="rounded-corner" >
<thead><?php echo Edition2();?><th class="<?php echo rond2(); ?>">Nom</th>
<th>Prenom</th>
<th>classe</th>
<th>Promotion</th>
<th>Matiere</th>
<th>Date devoir</th>
<th>Coefficient</th>
<th>Semestre</th>
<th>N° de devoir</th>
<th class="rounded-q4">Note</th></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan2(9,11); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
?> <tr> <?php
if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ 
echo '<td><a href="modif_eval.php?modif_eval='.$a['numeval'].'">modifier</a></td><td><a href="modif_eval.php?supp_eval='.$a['numeval'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">supprimer</a></td>';}
echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['coeficient'].'</td><td>S'.$a['numsem'].'</td><td>'.$a['n_devoir'].'</td><td>'.$a['note'].'</td></tr>';
}
?>
</tbody>
<tr></tr>
</table>
<a class="btn btn-dark" href="afficher_evaluation.php">Revenir à la page principale !</a>
<?php }
else {
$retour=mysqli_query($conn, "select distinct nom from classe");
?>
<form method="post" action="afficher_evaluation.php" class="form">
  <h3 class="text-center">Veuillez choisir le Semestre, la promotion et la classe</h3>
  <h3 class="text-center">Critères d'affichage</h3>
  <div class="row justify-content-center m-4 flex-column align-items-center text-center">
    <label for="">Promotion</label>
    <select class="col-2" name="promotion"> 
    <?php while($a=mysqli_fetch_array($data)){
    echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
    }?></select>
  </div>
  <div class="row justify-content-center m-4 flex-column align-items-center text-center">
    <label for="">Classe</label>
    <select class="col-2" name="nomcl"> 
    <?php while($a=mysqli_fetch_array($retour)){
    echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
    }?></select>
  </div>
  <div class="row justify-content-center m-4 flex-column align-items-center text-center">
    <label for="">Semestre</label>
    <select class="col-2" name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
    </select>
  </div>
  <div class="row justify-content-center m-4 flex-column align-items-center text-center">
    <input class="btn btn-dark col-2" type="submit" value="Afficher les matieres">
  </div>
</form>
<?php } ?>
</div>
</body>
</html>