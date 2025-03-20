<?php
include('cadre.php');
if(isset($_GET['modif_classe'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_classe'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select codecl,classe.nom as nomcl,promotion,numprofcoord,prof.nom,prenom from classe,prof where numprof=numprofcoord and codecl='$id'"));
$promo=mysqli_query($conn, "select distinct promotion from classe");
$prof=mysqli_query($conn, "select numprof,nom,prenom from prof");
$nom=stripslashes($ligne['nomcl']);
$numprof=stripslashes($ligne['numprofcoord']);
$promotion=stripslashes($ligne['promotion']);
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/modifier_classe.png" class="position_titre">
  </div>


<form action="modif_classe.php" method="POST" class="form">
	<h4 class="text-center">Veuillez choisir les nouveaux informations</h4>
	<div class="row justify-content-center text-center m-4">
		<label for="">Nom de la classe</label>
		<input class="col-4" type="text" name="nom" value="<?php echo $nom; ?>">
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Prof coordinataire</label>
		<select class="col-3" name="prof"> 
		<?php while($a=mysqli_fetch_array($prof)){
		echo '<option value="'.$a['numprof'].'" '.choixpardefault2($a['numprof'],$numprof).'>'.$a['nom'].' '.$a['prenom'].'</option>';
		}?>
		</select>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Promotion</label>
		<select class="col-3" name="promo"> 
		<?php while($a=mysqli_fetch_array($promo)){
		echo '<option value="'.$a['promotion'].'" '.choixpardefault2($a['promotion'],$promotion).'>'.$a['promotion'].'</option>';
		}?>
		</select>
	</div>
	<div class="row justify-content-center text-center m-4">
		<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
	</div>
	<div class="row justify-content-center text-center m-4">
		<input class="btn btn-dark col-2" type="submit" value="modifier">
	</div>
</form>
<a class="btn btn-dark" href="affiche_classe.php">Revenir à la page précédente !</a>
<?php
}
if(isset($_POST['nom'])){//s'il a cliquer sur le bouton modifier
	if($_POST['nom']!=""){
		$id=$_POST['id'];
		$nom=addslashes(Htmlspecialchars($_POST['nom']));
		$prof=addslashes(Htmlspecialchars($_POST['prof']));
		$promo=addslashes(Htmlspecialchars($_POST['promo']));
		mysqli_query($conn, "update classe set nom='$nom',numprofcoord='$prof',promotion='$promo' where codecl='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succès!"); </SCRIPT> <?php
		echo '<a class="btn btn-dark" href="modif_classe.php?modif_classe='.$id.'">Revenir à la page precedente !</a>';
	}
	else{
		echo '<h1>erreur! Vous devez remplire tous les champss<h1>';
		echo '<a class="btn btn-dark" href="modif_classe.php?modif_classe='.$id.'">Revenir à la page  precedente  !</a>';
	}
}
if(isset($_GET['supp_classe'])){
$id=$_GET['supp_classe'];
mysqli_query($conn, "delete from classe where codecl='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!"); </SCRIPT> <?php
echo '<a class="btn btn-dark" href="affiche_classe.php">Revenir à la page  precedente !</a>';
}
?>
</div>
<?php include ("../pages/footer.php"); ?>