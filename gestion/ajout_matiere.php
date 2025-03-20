<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/ajout_matiere.png" class="position_titre">
  </div>
<?php
if(isset($_POST['promotion'])){
$_SESSION['promo']=$_POST['promotion'];//pour l'envoyer la 2eme fois 
$_SESSION['nomcl']=$_POST['nomcl'];
?>
<form action="ajout_matiere.php" method="POST" class="form">
	<h3 class="text-center">Veuillez saisir la nouvelle matière</h3>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="form-label col-8" for="">Matière</label>
		<input class="col-8" type="text" name="nommat">
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<input class="col-2 btn btn-dark" type="submit" value="Ajouter">
	</div>
</form>
<?php }
else if(isset($_POST['nommat'])){//s'il a cliquer sur ajouter la 2eme fois
	if($_POST['nommat']!=""){
		$nomcl=$_SESSION['nomcl'];
		$nommat=addslashes(Htmlspecialchars($_POST['nommat']));
		$promo=$_SESSION['promo'];
		$codeclasse=mysqli_fetch_array(mysqli_query($conn, "select codecl from classe where nom='$nomcl' and promotion='$promo'"));
		$codecl=$codeclasse['codecl'];
		$compte=mysqli_fetch_array(mysqli_query($conn, "select count(*) as nb from matiere where nommat='$nommat' and codecl='$codecl'"));
		$bool=true;
		if($compte['nb']>0){
			$bool=false;
			?> <SCRIPT LANGUAGE="Javascript">	alert("Erreur d\'insertion, l\'enregistrement existe d�ja"); </SCRIPT> <?php
		}
		if($bool==true){
			mysqli_query($conn, "insert into matiere(nommat,codecl) values ('$nommat','$codecl')");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Ajouté avec succès!"); </SCRIPT> <?php
		}
	}
	else {
	?> <SCRIPT LANGUAGE="Javascript">	alert("Veuilliez remplire tous les champs!"); </SCRIPT> <?php
	}
	echo '<a class="btn btn-dark" href="Ajout_matiere.php">Revenir à la page précédente !</a>';
}
 else{
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");//select pour les promotions
$nomclasse=mysqli_query($conn, "select distinct nom from classe");
 ?>
 <form action="ajout_matiere.php" method="POST" class="form">
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label for="">Promotion</label>
		<select class="col-2" name="promotion"> 
		<?php while($a=mysqli_fetch_array($data)){
		echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
		}?>
		</select>
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label for="">Classe</label>
		<select class="col-2" name="nomcl"> 
		<?php while($a=mysqli_fetch_array($nomclasse)){
		echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
		}?></select>
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<input class="col-2 btn btn-dark" type="submit" value="Suivant">
	</div>

</form>
<?php } ?>
</div>
<?php include ("../pages/footer.php"); ?>
