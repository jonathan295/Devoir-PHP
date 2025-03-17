<?php
include('cadre.php');
include('calendrier.html');
if(isset($_GET['modif_el'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_el'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select * from eleve,classe where eleve.codecl=classe.codecl and numel='$id'"));
$nom=stripslashes($ligne['nomel']);
$prenom=stripslashes($ligne['prenomel']);
$date=stripslashes($ligne['date_naissance']);
$phone=stripslashes($ligne['telephone']);
$adresse=str_replace("<br />",' ',$ligne['adresse']);
$codecl=stripslashes($ligne['codecl']);
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/modif_eleve.png" class="position_titre">
  </div>
<form action="modif_eleve.php" method="POST" class="form">
	<h3 class="text-center">Modifier un étudiant</h3>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Nom étudiant</label>
		<p><?php echo $nom; ?></p>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Prénom</label>
		<p><?php echo $prenom; ?></p>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Date de naissance</label>
		<input class="col-2 text-center" type="text" name="date" class="calendrier" value="<?php echo $date; ?>">
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Adresse</label>
		<textarea name="adresse"><?php echo $adresse; ?></textarea>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Telephone</label>
		<input class="col-2 text-center" type="text" name="phone" value="<?php echo $phone; ?>">
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Classe</label>
		<?php echo $ligne['nom']; ?>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Promotion</label>
		<?php echo $ligne['promotion']; ?>
	</div>
	<!-- <div class="row justify-content-center flex-column align-items-center text-center m-4"> -->
		<input type="hidden" name="id" value="<?php echo $id; ?>">
	<!-- </div> -->
	<div class="row justify-content-center text-center m-4">
		<input type="submit" value="MODIFIER" class="btn btn-dark col-2">
	</div>
</form>
<a class="btn btn-dark" href="listeEtudiant.php?nomcl=<?php echo $ligne['nom']; ?>">Revenir à la page précédente !</a>
</div>
<?php
}
if(isset($_POST['adresse'])){
	if($_POST['date']!="" and $_POST['adresse']!="" and $_POST['phone']!=""){
		$id=$_POST['id'];
		$date=addslashes(Htmlspecialchars($_POST['date']));
		$phone=addslashes(Htmlspecialchars($_POST['phone']));
		$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
		mysqli_query($conn, "update eleve set date_naissance='$date', adresse='$adresse', telephone='$phone' where numel='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succès!"); </SCRIPT> 
		<?php
		
	}
	else{
	?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champss"); </SCRIPT> <?php
	}
	echo '<a style="width: 100%;" class="btn btn-dark" href="modif_eleve.php?modif_el='.$id.'">Revenir à la page precedente !</a>';
}
if(isset($_GET['supp_el'])){
$id=$_GET['supp_el'];
mysqli_query($conn, "delete from eleve where numel='$id'");
mysqli_query($conn, "delete from evaluation where numel='$id'");/*	Supprimier tous les entres en relation		*/
mysqli_query($conn, "delete from stage where numel='$id'");
mysqli_query($conn, "delete from bulletin where numel='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!"); </SCRIPT> <?php
echo '<a class="btn btn-dark" href="/gestion00/index.php?">Revenir à la page principale !</a>';
}
?>
</body>
</html>