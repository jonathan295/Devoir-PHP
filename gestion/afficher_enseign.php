<?php
include('cadre.php');
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
?>
<div class="container d-flex align-items- justify-content-center flex-column">
   <div class="container d-flex align-items- justify-content-center">
   	<img src="titre_img/affich_enseign.png" class="position_titre">
   </div>
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
	$nomcl=$_POST['nomcl'];
	$semestre=$_POST['radiosem'];
	$promo=$_POST['promotion'];
	$donnee=mysqli_query($conn, "select enseignement.id,classe.nom as nomcl,nommat,prof.nom,numsem,promotion from enseignement,classe,matiere,prof where matiere.codemat=enseignement.codemat and enseignement.codecl=classe.codecl and prof.numprof=enseignement.numprof and classe.nom='$nomcl' and promotion='$promo' and enseignement.numsem='$semestre'");
	?>
	<table class="table table-hover table-striped table-bordered" id="rounded-corner">
	<thead><tr><?php echo Edition();?><th class="<?php echo rond(); ?>">Classe</th>
	<th class="rounded-q1">Promotion</th>
	<th class="rounded-q1">Matière</th><th class="rounded-q1">Professeur</th><th class="rounded-q4">Semestre</th></tr></thead>
	<tfoot>
	<tr>
	<td colspan="<?php echo colspan(4,6); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
	<td class="rounded-foot-right">&nbsp;</td>
	</tr>
	</tfoot>
	<tbody>
	<?php
		while($a=mysqli_fetch_array($donnee)){
			if(isset($_SESSION['admin'])){
				echo '<td><a href="modif_enseign.php?modif_ensein='.$a['id'].'" >modifier</a></td><td><a href="modif_enseign.php?supp_ensein='.$a['id'].'" onclick="return(confirm(\'Etes-vous s�r de vouloir supprimer cette entr�e?\ntous les enregistrements en relation avec cette entr�e seront perdus\'));">Supprimer</td>';} echo '<td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nommat'].'</td><td>'.$a['nom'].'</td><td>S'.$a['numsem'].'</td></tr>';
			}
	?>
	<tbody>
	<tr></tr>
	</table>
	<a class="btn btn-dark" href="afficher_enseign.php">Revenir à la page précédente !</a>
	<?php
}
else {
$retour=mysqli_query($conn, "select distinct nom from classe");
?>

<form method="post" action="afficher_enseign.php" class="form">
	<h3 class="text-center">Critères d'affichage</h3> 
	<div class="row justify-content-center flex-column align-items-center text-center m-4"">
		<label for="">Classe</label>
		<select class="col-2" name="nomcl"> 
		<?php while($a=mysqli_fetch_array($retour)){
		echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
		}?></select>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4"">
		<label for="">Promotion</label>
		<select class="col-2" name="promotion"> 
		<?php while($a=mysqli_fetch_array($data)){
		echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
		}?></select>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4"">
		<label for="">Semestre</label>
		<select class="col-2" name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
		</select>
	</div>
	<div class="row justify-content-center text-center m-4"">
		<input class="btn btn-dark col-2" type="submit" value="Afficher">
	</div>
</form>
<?php } ?>
</div>
</body>
</html>