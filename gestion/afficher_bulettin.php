<?php
include('cadre.php');
$data=mysqli_query($conn,"select distinct promotion from classe order by promotion desc");
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/affich_bulletin.png" class="position_titre">
  </div>
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$semestre=$_POST['radiosem'];
$matiere=mysqli_query($conn,"select matiere.codemat,nommat from enseignement,matiere where enseignement.codemat=matiere.codemat and enseignement.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and numsem='$semestre'"); ?>
<form method="post" action="afficher_bulettin.php" class="form">
<h3 class="text-center"><?php echo "Veuillez choisir la matiere pour : $nomcl $promo";?></h3>

<h3 class="text-center">Matières étudiées</h3>
<div class="row justify-content-center m-4 flex-column align-items-center text-center">
  <label class="col-2" for="">Matière:</label>
  <select class="col-2" name="codemat"> 
  <?php while($c=mysqli_fetch_array($matiere)){
  echo '<option value="'.$c['codemat'].'">'.$c['nommat'].'</option>';
  }?></select>
</div>
<!-- <div class="row justify-content-center m-4 flex-column align-items-center"> -->
  <input type="hidden" name="nomclasse" value="<?php echo $nomcl; ?>">
<!-- </div> -->
<!-- <div class="row justify-content-center m-4 flex-column align-items-center"> -->
  <input type="hidden" name="promo" value="<?php echo $promo; ?>">
<!-- </div> -->
<!-- <div class="row justify-content-center m-4 flex-column align-items-center"> -->
  <input type="hidden" name="semestre" value="<?php echo $semestre; ?>">
<!-- </div> -->
<div class="row justify-content-center m-4">
  <input class="btn btn-dark col-3" type="submit" value="Afficher les notes finals">
</div>
<div class="row justify-content-center m-4 flex-column align-items-center">
  <a class="btn btn-dark" href="afficher_bulettin.php">Revenir à la page precedente !</a>
</div>
</form>

<?php
}
else if(isset($_POST['codemat'])){//apres avoir choisis la matiere on affiche les notes
$nomcl=$_POST['nomclasse'];//GI
$semestre=$_POST['semestre'];//4
$promo=$_POST['promo'];//2009
$codemat=$_POST['codemat'];//5
/*		selectionner tout les devoir pour la classe choisis dans le semestre choisis			*/
$dev1=mysqli_query($conn,"select nomel,prenomel,nom,promotion,nommat,numsem,notefinal from eleve,classe,matiere,bulletin where eleve.numel=bulletin.numel and classe.codecl=eleve.codecl and matiere.codemat=bulletin.codemat and matiere.codemat='$codemat' and numsem='$semestre' and eleve.numel in (select numel from eleve where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo'))");
?>
<table id="rounded-corner" class="table table-striped table-hover table-bordered">
<thead><tr><th class="rounded-company">Nom</th>
<th class="rounded-q1">Prenom</th>
<th class="rounded-q3">classe</th>
<th class="rounded-q3">Promotion</th>
<th class="rounded-q3">Matiere</th>
<th class="rounded-q3">Semestre</th>
<th class="rounded-q4">Note Final</th></tr></thead>
<tfoot>
<tr><td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td></tr>
</tfoot>
 <tbody>
 <?php
   while($a=mysqli_fetch_array($dev1)){
    echo '<tr><td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td >'.$a['nom'].'</td><td >'.$a['promotion'].'</td><td>'.$a['nommat'].'</td><td>'.$a['numsem'].'</td><td>'.$a['notefinal'].'</td></tr>';
   }
   ?>

 </tbody>
 <tr></tr>
</table>
<a class="btn btn-dark" href="afficher_bulettin.php">Revenir à la page precedente !</a>
<?php
}
else {
$retour=mysqli_query($conn,"select distinct nom from classe"); // afficher les classes
?>
<form method="post" action="afficher_bulettin.php" class="form">
  <h3 class="text-center">Veuillez choisir le Semestre, la promotion et la classe :</h3>
  <h3 class="text-center">Critères d'affichage</h3>  
  <div class="row justify-content-center m-4 flex-column align-items-center text-center">
    <label class="col-4" for="">Promotion:</label>
    <select class="col-4" name="promotion"> 
    <?php while($a=mysqli_fetch_array($data)){
    echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
    }?></select>    
  </div>
  <div class="row justify-content-center m-4 flex-column align-items-center text-center">
    <label class="col-4" for="">Classe:</label>
    <select class="col-4" name="nomcl"> 
    <?php while($a=mysqli_fetch_array($retour)){
    echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
    }?></select>
  </div>
  <div class="row justify-content-center m-4 flex-column align-items-center text-center">
    <label class="col-4" for="">Semestre:</label>
    <select class="col-4" name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
    </select>
  </div>
  <div class="row justify-content-center m-4 flex-column align-items-center">
    <input class="btn btn-dark" type="submit" value="Afficher les matieres">
  </div>
</form>
<?php } ?>
</pre>
</div>
</body>
</html>