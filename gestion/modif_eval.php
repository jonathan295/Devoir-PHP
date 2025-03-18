<?php
include('cadre.php');
echo '<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/modif_evalu.png" class="position_titre">
  </div>';
if(isset($_GET['modif_eval'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_eval'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select * from evaluation,eleve,classe where eleve.numel=evaluation.numel and eleve.codecl=classe.codecl and numeval='$id'"));//Pour afficher le nom de l'eleve et la note par deflault et le devoir,
$codecl=$ligne['codecl'];
$eleve=mysqli_query($conn, "select numel,nomel,prenomel from eleve where codecl='$codecl'");
$numdev=stripslashes($ligne['numdev']);
$mat_dev=mysqli_fetch_array(mysqli_query($conn, "select * from matiere,devoir where devoir.codemat=matiere.codemat and numdev='$numdev'"));//pour selection la classe par defualt et afficher la promotion
?>
<form action="modif_eval.php" method="POST" class="form">
	<div class="row">
		<label for="">Matière</label>
		<p><?php echo $mat_dev['nommat']; ?></p>
	</div>
	<div class="row">
		<label for="">Matière</label>
		<p><?php echo $mat_dev['nommat']; ?></p>
	</div>
	<div class="row">
		<label for="">Classe</label>
		<p><?php echo stripslashes($ligne['nom']); ?></p>
	</div>
	<div class="row">
		<label for="">Promotion</label>
		<p><?php echo stripslashes($ligne['promotion']); ?></p>
	</div>
	<div class="row">
		<label for="">Date du devoir</label>
		<p><?php echo stripslashes($mat_dev['date_dev']); ?></p>
	</div>
	<div class="row">
		<label for="">Coefficient</label>
		<p><?php echo stripslashes($mat_dev['coeficient']); ?></p>
	</div>
	<div class="row">
		<label for="">Semestre</label>
		<p><?php echo $mat_dev['numsem']; ?></p>
	</div>
	<div class="row">
		<label for="">Devoir N°</label>
		<p><?php echo $mat_dev['n_devoir']; ?></p>
	</div>
	<div class="row">
		<label for="">Etudiant</label>
		<select class="col-4" name="numel"> 
		<?php while($a=mysqli_fetch_array($eleve)){
		echo '<option value="'.$a['numel'].'" '.choixpardefault2($a['numel'],$ligne['numel']).'>'.$a['nomel'].' '.$a['prenomel'].'</option>';
		}?></select>
	</div>
	<div class="row">
		<label for="">Note</label>
		<input class="col-8" type="text" name="note" value="<?php echo $ligne['note']; ?>">
	</div>   
	<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
	<div class="row">
		<input class="btn btn-dark col-2" type="submit" value="MODIFIER">	
	</div>
</form>
<?php
echo '<a class="btn btn-dark" href="afficher_evaluation.php">Revenir à la page précédente !</a>';
}
if(isset($_POST['numel'])){//s'il a cliquer sur le bouton modifier
	if($_POST['note']!=""){
		$id=$_POST['id'];
		$numel=$_POST['numel'];
		$note=str_replace(",",".",$_POST['note']);//remplacer la , par .
		mysqli_query($conn, "update evaluation set numel='$numel', note='$note' where numeval='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succès!"); </SCRIPT> <?php
	}
	else{
		?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champss"); </SCRIPT> <?php
		}
	echo '<br/><br/><a href="modif_eval.php?modif_eval='.$id.'">Revenir à la page precedente !</a>';
}
if(isset($_GET['supp_eval'])){
$id=$_GET['supp_eval'];
mysqli_query($conn, "delete from evaluation where numeval='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!"); </SCRIPT> <?php
echo '<a class="btn btn-dark" href="afficher_evaluation.php">Revenir à la page d\'affichage</a>'; //on revient � la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</div>
<?php include ("../pages/footer.php"); ?>