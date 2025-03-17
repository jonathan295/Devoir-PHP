<?php
include('cadre.php');
?>
<?php if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])): ?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/cherche_prof.png" class="position_titre">
  </div>

<?php if(isset($_GET['cherche_prof'])){ 
$retour=mysqli_query($conn, "select distinct nom from classe"); // afficher les classes
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
?>

<form action="chercher_prof.php" method="post" class="form">
	<div class="row m-4 justify-content-center">
		<label class="col-2" for="">Nom du prof:</label class="col-4">
		<input class="col-4" type="text" name="nomel">
	</div>
	<div class="row m-4 justify-content-center">
		<label class="col-2" for="">Prenom du prof:</label class="col-4">
		<input class="col-4" type="text" name="prenomel">
	</div>
	<div class="row m-4 justify-content-center flex-column align-items-center">
		<label class="col-6 text-center" for="">vous pouvez préciser la promotion si vous voulez :</label class="col-4">
		<select class="col-4" name="promotion"> 
			<option value="">Choisir la promotion</option>
			<?php while($a=mysqli_fetch_array($data)){
			echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
			}?>
		</select>
	</div>
	<div class="row m-4 justify-content-center flex-column align-items-center">
		<label class="col-6 text-center" for="">Vous pouvez préciser la classe si vous voulez :</label class="col-4">
		<select class="col-4" name="nomcl"> 
			<option value="">Choisir la classe</option>
			<?php while($a=mysqli_fetch_array($retour)){
			echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
			}?>
		</select>
	</div>
	<div class="row m-4 justify-content-center">
		<input class="btn btn-dark col-2" class="btn btn-dark col-2" type="submit" value="Rechercher">
	</div>
</form>
<a class="btn btn-dark" href="index.php">Revenir à la page principale!</a>
<?php
}
else if(isset($_POST['nomel'])){
	$nomprof=$_POST['nomel'];
	$prenomprof=$_POST['prenomel'];
	$nomcl=$_POST['nomcl'];
	$promo=$_POST['promotion'];
	$option="";
	if($nomcl!="" and $promo=="")
	$option="and classe.nom='$nomcl'";
	else if($promo!="" and $nomcl=="")
	$option="and classe.promotion='$promo'";
	else if($promo!="" and $nomcl!="")
	$option="and classe.nom='$nomcl' and promotion='$promo'";
	$cherche=mysqli_query($conn, "select classe.codecl,prof.numprof,prof.nom as nomp,nommat,prof.prenom as prenomp,adresse,telephone,classe.nom,promotion from prof,classe,enseignement,matiere where matiere.codemat=enseignement.codemat and classe.codecl=enseignement.codecl and prof.numprof=enseignement.numprof and prof.nom LIKE '%$nomprof%' and prof.prenom LIKE '%$prenomprof%' ".$option."");//option contient les info suplimentaire
?>
<table id="rounded-corner" class="table table-striped table-hover table-bordered">
<thead><tr><th class="rounded-company">Nom du prof</th>
<th class="rounded-q1">Prenom du prof</th>
<th class="rounded-q3">Adresse</th>
<th class="rounded-q3">Telepohne</th>
<th class="rounded-q3">Classe enseignée</th>
<th class="rounded-q3">Matière enseignée</th>
<th class="rounded-q4">Promotion</th></tr></thead>
<tfoot>
<tr><td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td></tr>
</tfoot>
 <tbody>
 <?php
	while($a=mysqli_fetch_array($cherche)){
		echo '<tr><td>'.$a['nomp'].'</td><td>'.$a['prenomp'].'</td><td >'.$a['adresse'].'</td><td >'.$a['telephone'].'</td><td>'.$a['nom'].'</td><td>'.$a['nommat'].'</td><td>'.$a['promotion'].'</td></tr><tr></tr>';
	}
	?>
	</tbody>
	</table>
	<a class="btn btn-dark" href="chercher_prof.php?cherche_prof=true">Revenir à la page precedente !</a>
	<?php
	}
?>
<?php endif; ?>
</div>
</body>
</html>