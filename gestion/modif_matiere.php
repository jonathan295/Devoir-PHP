<?php
include('cadre.php');
echo '<div class="container d-flex align-items- justify-content-center flex-column">';
if(isset($_GET['modif_matiere'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_matiere'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select * from matiere,classe where classe.codecl=matiere.codecl and codemat='$id'"));//classe pour afficher la promotion
$nom=stripslashes($ligne['nommat']);
$codecl=stripslashes($ligne['codecl']);
$promo=mysqli_fetch_array(mysqli_query($conn, "select promotion,nom from classe where codecl='$codecl'"));//pour selection la classe par defualt et afficher la promotion
?>
<h1 class="text-center">Modifier une matière</h1>
<form action="modif_matiere.php" method="POST" class="form">
	<div class="row justify-content-center text-center m-4">
		<label for="">Matière</label>
		<input class="col-4" type="text" name="nommat" value="<?php echo $nom; ?>">
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Classe</label>
		<p><?php echo $promo['nom']; ?></p>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Promotion</label>
		<p><?php echo $promo['promotion']; ?></p>
	</div>
	<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
	<div class="row justify-content-center text-center m-4">
		<input class="col-2" type="submit" value="MODIFIER">
	</div>
</form>
<?php
echo '<a class="btn btn-dark" href="affiche_matiere.php?nomcl='.$promo['nom'].'">Revenir à la page précédente !</a>';
}
if(isset($_POST['nommat'])){//s'il a cliquer sur le bouton modifier
	if($_POST['nommat']!=""){
		$id=$_POST['id'];
		$nom=addslashes(Htmlspecialchars($_POST['nommat']));
		mysqli_query($conn, "update matiere set nommat='$nom' where codemat='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succès!"); </SCRIPT> <?php
	}
	else{
		?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champss"); </SCRIPT> <?php
		}
	echo '<a class="btn btn-dark" href="modif_matiere.php?modif_matiere='.$id.'">Revenir à la page precedente !</a>';
}
if(isset($_GET['supp_matiere'])){
$id=$_GET['supp_matiere'];
mysqli_query($conn, "delete from matiere where codemat='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!"); </SCRIPT> <?php
echo '<a class="btn btn-dark" href="index.php">Revenir à la page  principale!</a>'; //on revient � la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</div>