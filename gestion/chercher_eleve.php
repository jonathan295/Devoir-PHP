<?php
include('cadre.php');
if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])): ?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/cherche_eleve.png" class="position_titre">
  </div>

<?php if(isset($_GET['cherche_eleve'])){ 
$retour=mysqli_query($conn,"select distinct nom from classe"); // afficher les classes
$data=mysqli_query($conn,"select distinct promotion from classe order by promotion desc");
?>
<form action="chercher_eleve.php" method="post" class="form">
	<h3 class="text-center">Critère de recherche</h3>
	<div class="row justify-content-center m-4">
		<label class="col-4" for="">Nom:</label class="col-4">
		<input class="col-4" type="text" name="nomel">
	</div>
	<div class="row justify-content-center m-4">
		<label class="col-4" for="">Prenom:</label class="col-4">
		<input class="col-4" type="text" name="prenomel">
	</div>
	<div class="row justify-content-center">
		<div class="col-5 justify-content-center m-4 flex-column text-center align-items-center">
			<label class="col-12" for="">vous pouvez préciser la promotion si vous voulez:</label class="col-4">
			<select class="col-12" name="promotion"> 
			<option value="">Choisir la promotion</option>
			<?php while($a=mysqli_fetch_array($data)){
			echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
			}?>
			</select>
		</div>
		<div class="col-5 justify-content-center m-4 flex-column text-center align-items-center">
			<label class="col-12" for="">Vous pouvez préciser la classe si vous voulez:</label class="col-4">
			<select class="col-12" name="nomcl"> 
			<option value="">Choisir la classe</option>
			<?php while($a=mysqli_fetch_array($retour)){
			echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
			}?></select>
		</div>
	</div>
	<div class="row justify-content-center m-4">
		<input class="btn btn-dark col-2" class="btn btn-dark col-2" type="submit" value="Rechercher">
	</div>
</form>
<div class="row justify-content-center m-4">
	<a class="btn btn-dark" href="index.php">Revenir à la page principale!</a>
</div>
<?php
}
else if(isset($_POST['nomel'])){
	$nomel=$_POST['nomel'];
	$prenomel=$_POST['prenomel'];
	$nomcl=$_POST['nomcl'];
	$promo=$_POST['promotion'];
	$option="";
	if($nomcl!="" and $promo=="")
	$option="and eleve.codecl in (select codecl from classe where nom='$nomcl')";
	else if($promo!="" and $nomcl=="")
	$option="and eleve.codecl in (select codecl from classe where promotion='$promo')";
	else if($promo!="" and $nomcl!="")
	$option="and eleve.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo')";
	$cherche=mysqli_query($conn,"select * from eleve,classe where classe.codecl=eleve.codecl and nomel LIKE '%$nomel%' and prenomel LIKE '%$prenomel%' ".$option."");//option contient les info suplimentaire

	if (mysqli_num_rows($cherche)==0){
	$_SESSION["r_vide"] = "Aucune correspendance trouvée";
		echo $_SESSION["r_vide"];
	} 

?>
<table id="rounded-corner" class="table table-striped table-hover table-bordered table-light">
<thead><tr><th class="rounded-company">Nom</th>
<th class="rounded-q1">Prenom</th>
<th class="rounded-q3">Adresse</th>
<th class="rounded-q3">Date de naissance</th>
<th class="rounded-q3">Telepohne</th>
<th class="rounded-q3">Classe</th>
<th class="rounded-q4">Promotion</th></tr></thead>
<tfoot>
<tr><td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td></tr>
</tfoot>
 <tbody>
 <?php
	while($a=mysqli_fetch_array($cherche)){
		echo '<tr><td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td >'.$a['adresse'].'</td><td >'.$a['date_naissance'].'</td><td >'.$a['telephone'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td></tr>';
	}
	?>
	</tbody>
	</table>
	<a class="btn btn-dark" href="chercher_eleve.php?cherche_eleve=true">Revenir à la page precedente !</a>
	<?php
	}
	?>
<?php endif; ?>
</div>
<?php include ("../pages/footer.php"); ?>