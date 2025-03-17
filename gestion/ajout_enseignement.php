<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
   <div class="container d-flex align-items- justify-content-center">
   	<img src="titre_img/ajout_enseignemt.png" class="position_titre">
   </div>
<?php
if(isset($_POST['nomcl'])){
$_SESSION['nomcl']=$_POST['nomcl'];
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$promo;//pour l'envoyer la 2eme fois 
$donnee=mysqli_query($conn, "select codemat,nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$nomcl' and promotion='$promo'");
$prof=mysqli_query($conn, "select numprof,nom,prenom from prof");
?>
<form action="ajout_enseignement.php" method="POST" class="form">
	<h3 class="text-center">Ajoutet un enseignement</h3>  
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Matière</label>
		<select class="col-2" name="choix_mat" id="choix">
		<?php while($a=mysqli_fetch_array($donnee)){ echo '<option value="'.$a['codemat'].'">'.$a['nommat'].'</option>'; } ?>
		</select>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Enseignant</label>
		<select class="col-2" name="n_prof"><?php while($prof2=mysqli_fetch_array($prof)){ echo '<option value="'.$prof2['numprof'].'">'.$prof2['nom'].' '.$prof2['prenom'].'</option>'; } ?>
		</select>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Semestre</label>
		<select class="col-2" name="semestre"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
		</select>
	</div>
	<div class="row justify-content-center text-center m-4">
		<input class="btn btn-dark col-2" type="submit" value="Ajouter">
	</div>
</form>
<?php }
else if(isset($_POST['semestre'])){//s'il a cliquer sur ajouter la 2eme fois
$semestre=$_POST['semestre'];
$codemat=$_POST['choix_mat'];
$nomcl=$_SESSION['nomcl'];
$n_prof=$_POST['n_prof'];//Premier ou 2eme devoir -- 1 ou 2
$promo=$_SESSION['promo'];
$codeclasse=mysqli_fetch_array(mysqli_query($conn, "select codecl from classe where nom='$nomcl' and promotion='$promo'")) ;
$codecl=$codeclasse['codecl'];
/*
 pour ne pas ajouter deux enseignements similaires
 */
$data=mysqli_query($conn, "select count(*) as nb from enseignement where codecl='$codecl'  and codemat='$codemat' and numsem='$semestre'");
/*
 pour verifier si l'enseignemet (codecl,nommat,numsem) existe ou deja
 */
 
$nb=mysqli_fetch_array($data);


$bool=true;
	
	/*
	pour ne pas ajouter deux controles similaire
	*/
	if($nb['nb']>0){
		$bool=false;
		echo '<br\><h2>Erreur d\'insertion!! (impossible d\'ajouter deux enseignements similaires)</h2>';
		?><SCRIPT LANGUAGE="Javascript">alert("Erreur d\'insertion\nimpossible d\'ajouter deux enseignements similaires");</SCRIPT><?php
	}
	if($bool==true){
	mysqli_query($conn, "insert into enseignement(codecl,codemat,numprof,numsem) values('$codecl','$codemat','$n_prof','$semestre')");
	?> <SCRIPT LANGUAGE="Javascript">	alert("Ajouté avec succès!"); </SCRIPT> <?php
	}
	echo '<div class="row"><a class="btn btn-dark" href="ajout_enseignement.php?">Revenir à la page precedente !</a></div>';
}
 else {
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");//select pour les promotions
$donnee=mysqli_query($conn, "select distinct nom from classe"); 
?>
 <form action="ajout_enseignement.php" method="POST" class="form">
	<h3 class="text-center">Veuillez choisir la classe et la promotion</h3>
	<h3 class="text-center">Critères d'ajout</h3> 
		<div class="row justify-content-center flex-column align-items-center text-center m-4">
			<label for="">Classe</label>
			<select class="col-2" name="nomcl"> 
			<?php while($a=mysqli_fetch_array($donnee)){
			echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
			}?></select>
		</div>
		<div class="row justify-content-center flex-column align-items-center text-center m-4">
			<label for="">Promotion</label>
			<select class="col-2" name="promotion"> 
			<?php while($a=mysqli_fetch_array($data)){
			echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
			}?></select>
		</div>
		<div class="row justify-content-center text-center m-4">
			<input class="btn btn-dark col-2" type="submit" value="Afficher">
		</div>
</form>
<?php } ?>
</div>
</html>
