<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
   <img src="titre_img/affich_note.png" class="position_titre">
  </div>
<?php
if(isset($_GET['nomcl'])){//affichage de la promotion
$nomcl=$_GET['nomcl'];
$_SESSION['nomcl']=$_GET['nomcl'];//session du nomcl choisis dans le menu pour laisser la variable jusqu'a la page ou on va afficher la liste
$data=mysqli_query($conn,"select promotion from classe where nom='$nomcl' order by promotion desc");
?>
<form action="afficher_note.php" method="POST" class="form">
   <h3 class="text-center">Veuillez choisir la promotion et le semestre pour <?php echo $nomcl; ?>:</h3>
   <h3 class="text-center">Critères d'affichage</h3>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label class="col-4" for="">Promotion:</label>
      <select class="col-4" name="promotion">
      <?php while($a=mysqli_fetch_array($data)){
      echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
      }?>
      </select>
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center text-center">
      <label class="col-4" for="">Semestre:</label>
      <select class="col-4" name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
      </select>
   </div>
   <div class="row justify-content-center m-4 flex-column align-items-center">
      <input class="btn btn-dark col-2" type="submit" value="afficher">
   </div>
</form>
<?php } 

if(isset($_POST['radiosem'])){
$nomcl=$_SESSION['nomcl'];
$_SESSION['semestre']=$_POST['radiosem'];
$promo=$_POST['promotion'];
$semestre=$_SESSION['semestre'];//seulement pour la requete
$donnee=mysqli_query($conn,"select nommat from matiere,enseignement,classe where matiere.codemat=enseignement.codemat and enseignement.codecl=classe.codecl and nom='$nomcl' and enseignement.numsem='$semestre' and promotion='$promo'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
$a=0;
//$_SESSION['classe']=$classe;
?>
<form method="post" action="afficher_note.php" class="form d-flex flex-column align-items-center">
  <h3 align=top>Matières étudiée</h3> 
   <p>
   <?php
   $i=1;
   while($a=mysqli_fetch_array($donnee)){
   echo '<input class="form-check-input" type="radio" name="radio" value="'.$a['nommat'].'" id="choix'.$i.'" /> <label for="choix'.$i.'">'.$a['nommat'].'</label><br /><br />';
   $i++;
   }
   ?>

<input class="btn btn-dark" type="submit" value="Afficher les notes">
   </p>
</form>
<?php
}
else if(isset($_POST['radio'])){
$semestre=$_SESSION['semestre'];
$nommat=$_POST['radio'];
$nomcl=$_SESSION['nomcl'];
$donnee=mysqli_query($conn,"select nomel,prenomel,nom,nommat,date_dev,coeficient,note from eleve,classe,matiere,devoir,evaluation where eleve.codecl=classe.codecl and evaluation.numdev=devoir.numdev and devoir.codemat=matiere.codemat and evaluation.numel=eleve.numel and matiere.nommat='$nommat' and nom='$nomcl' and devoir.numsem='$semestre'");
?><table id="rounded-corner" class="table table-stiped table-hover table-bordered">
<thead><tr><th class="rounded-company">Nom d'éleve</th>
<th scope="col" class="rounded-q2">Prenom d'éleve</th>
<th scope="col" class="rounded-q2">Classe</th>
<th scope="col" class="rounded-q2">Matiere</th>
<th scope="col" class="rounded-q2">Date du devoir</th>
<th scope="col" class="rounded-q2">Coefficient</th><th scope="col" class="rounded-q4">Note</th></tr></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
echo '<tr><td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['coeficient'].'</td><td>'.$a['note'].'</td></tr>';
}
?>
<tr></tr>
</tbody>
</table>
<?php
}//fin   if(isset($_POST['radio']
?>
<a class="btn btn-dark" href="afficher_bulettin.php">Revenir à la page precedente !</a>
</div>
<?php include ("../pages/footer.php"); ?>

