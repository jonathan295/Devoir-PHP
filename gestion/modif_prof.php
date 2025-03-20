<?php
include('cadre.php');
echo '<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/modif_prof.png" class="position_titre">
  </div>';
if(isset($_GET['modif_prof'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_prof'];
$ligne=mysqli_fetch_array(mysqli_query($conn,"select * from prof where numprof='$id'"));
$nom=stripslashes($ligne['nom']);
$prenom=stripslashes($ligne['prenom']);
$phone=stripslashes($ligne['telephone']);
$adresse=stripslashes($ligne['adresse']);
?>

<form action="modif_prof.php" method="POST" class="form">
	<div class="row justify-content-center text-center m-4">
		<label for="">Nom étudiant</label>
		<p><?php echo $nom; ?></p>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Prénom</label>
		<p><?php echo $prenom; ?></p>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Adresse</label>
		<textarea class="col-8" name="adresse" ><?php echo $adresse; ?></textarea>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Telephone</label>
		<input class="col-8" type="text" name="phone" value="<?php echo $phone; ?>">
	</div>
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<div class="row justify-content-center text-center m-4">
		<input class="col-2 btn btn-dark" type="submit" value="MODIFIER">
	</div>
</form>
<a class="btn btn-dark" href="afficher_prof.php?nomcl=<?php echo $ligne['nom']; ?>">Revenir à la page précédente !</a>
<?php
}
if(isset($_POST['nom'])){
	if($_POST['adresse']!="" and $_POST['phone']!=""){
		$id=$_POST['id'];
		$phone=addslashes(Htmlspecialchars($_POST['phone']));
		$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
		mysqli_query($conn,"update prof set adresse='$adresse', telephone='$phone' where numprof='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succès!"); </SCRIPT> <?php
		echo '<br/><br/><a href="modif_prof.php?modif_prof='.$id.'">Revenir à la page précedente !</a>';
	}
	else{
	?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champs"); </SCRIPT> <?php
		echo '<br/><br/><a href="index.php?">Revenir à la page principale !</a>';
	}
}
if(isset($_GET['supp_prof'])){
$id=$_GET['supp_prof'];
mysqli_query($conn,"delete from prof where numprof='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!"); </SCRIPT> <?php
echo '<div class="row justify-content-center"><a class="btn btn-dark col-4" href="/gestion/index.php?">Revenir à la page principale !</a></div>';
}
?>
</div>
<?php include ("../pages/footer.php"); ?>