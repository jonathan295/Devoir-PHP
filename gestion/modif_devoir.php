<?php
include('cadre.php');
include('calendrier.html');
echo '<div class="container d-flex align-items- justify-content-center flex-column">';
if(isset($_GET['modif_dev'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_dev'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select * from classe,devoir,matiere where classe.codecl=devoir.codecl and matiere.codemat=devoir.codemat and numdev='$id'"));//Pour afficher le nom de l'eleve et la note par deflault et le devoir,
$date=$ligne['date_dev'];

?>
<h1 class="text-center">Modifier un devoir</h1>
<form action="modif_devoir.php" method="POST" class="form">
	<div class="row">
		<label for="">Matière</label>
		<?php echo $ligne['nommat']; ?>
	</div>
	<div class="row">
		<label for="">Classe</label>
		<?php echo stripslashes($ligne['nom']); ?>
	</div>
	<div class="row">
		<label for="">Promotion</label>
		<?php echo $ligne['promotion']; ?>
	</div>
	<div class="row">
		<label for="">Coefficient</label>
		<input type="text" name="coeficient" value="<?php echo $ligne['coeficient']; ?>">
	</div>
	<div class="row">
		<label for="">Semestre</label>
		<?php echo $ligne['numsem']; ?>
	</div>
	<div class="row">
		<label for="">N° Devoir</label>
		<input type="text" name="n_devoir" value="<?php echo $ligne['n_devoir']; ?>">
	</div>
	<div class="row">
		<label for="">Date du devoir</label>
		<input type="text" name="date" class="calendrier" value="<?php echo $date; ?>"/>
	</div>
	<div class="row">
		<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
	</div>
	<div class="row">
		<input type="hidden" name="numdev" value="<?php echo $ligne['numdev']; ?>">
	</div>
	<div class="row">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
	</div>
	<div class="row">
		<input type="submit" value="Modifier" class="btn btn-dark">
	</div>
</form>
<?php
echo '<a class="btn btn-dark" href="afficher_devoir.php">Revenir à la page précédente !</a>';
}
if(isset($_POST['n_devoir'])){//s'il a cliquer sur le bouton modifier
	$id=$_POST['id'];
	if(($_POST['n_devoir']=="1" or $_POST['n_devoir']=="2") and $_POST['date']!="" and $_POST['coeficient']!=""){
		$n_devoir=$_POST['n_devoir'];
		$numdev=$_POST['numdev'];
		$coeficient=$_POST['coeficient'];
		$date=$_POST['date'];
		$compte=mysqli_fetch_array(mysqli_query($conn, "select count(*) as nb from devoir where n_devoir='$n_devoir' and numdev='$numdev' and date_dev='$date'"));
		if($compte['nb']!=0){//deux devoir similaire()2 devoirs par matiere
		?> <SCRIPT LANGUAGE="Javascript">	alert("erreur de modification,ce devoir existe déja(verifier le numero de devoir)"); </SCRIPT> <?php
		}
		else{
		mysqli_query($conn, "update devoir set n_devoir='$n_devoir', coeficient='$coeficient',date_dev='$date' where numdev='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succès!"); </SCRIPT> <?php
		}
	}
	else{
		?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champs(n° de devoir 1 ou 2)"); </SCRIPT> <?php
		}
	echo '<br/><br/><a href="modif_devoir.php?modif_dev='.$id.'">Revenir à la page precedente !</a>';
}
if(isset($_GET['supp_dev'])){
$id=$_GET['supp_dev'];
mysqli_query($conn, "delete from devoir where numdev='$id'");
mysqli_query($conn, "delete from evaluation where numdev='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!\ntous les evaluations de ce devoir ont été supprimées"); </SCRIPT> <?php
echo '<br/><br/><a href="afficher_devoir.php">Revenir à la page à l\'affichage</a>'; //on revient � la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</div>
<?php include ("../pages/footer.php"); ?>