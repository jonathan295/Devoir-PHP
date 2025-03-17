<?php
session_start();
include('cadre.php');
if(isset($_GET['modif_dip'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_dip'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select * from eleve,classe,eleve_diplome,diplome where eleve.numel=eleve_diplome.numel and classe.codecl=eleve.codecl and diplome.numdip=eleve_diplome.numdip and id='$id'"));
$titre=mysqli_query($conn, "select numdip,titre_dip from diplome");
?>

<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/modif_diplom.png" class="position_titre">
  </div>


<form action="modif_diplome.php" method="POST" class="form">
	<div class="row justify-content-center text-center m-4">
		<label for="">Nom et prénom</label>
		<p><?php echo $ligne['nomel'].' '.$ligne['prenomel']; ?></p>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Classe</label>
		<p><?php echo $ligne['nom']; ?></p>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Promotion</label>
		<p><?php echo $ligne['promotion']; ?></p>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Titre du diplôme</label>
		<select class="col-3" name="titre"><?php while($var=mysqli_fetch_array($titre)){  
		echo '<option value="'.$var['numdip'].'" '.choixpardefault2($var['titre_dip'],$ligne['titre_dip']).'>'.$var['titre_dip'].'</option>'; 
		} ?> </select>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Note</label>
		<input class="col-4" type="text" name="note" value="<?php echo $ligne['note']; ?>">
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Commentaire</label>
		<input class="col-4" type="text" name="comment" value="<?php echo $ligne['commentaire']; ?>">
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Etablissement</label>
		<input class="col-4" type="text" name="etabli" value="<?php echo $ligne['etablissement']; ?>">
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Lieu</label>
		<input class="col-4" type="text" name="lieu" value="<?php echo $ligne['lieu']; ?>">
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Année d'obtention</label>
		<input class="col-4" type="text" name="ann_obt" value="<?php echo $ligne['annee_obtention']; ?>">
	</div>
	<div class="row justify-content-center text-center m-4">
		<input class="col-4" type="hidden" name="id" value="<?php echo $id; ?>">
	</div>
	<div class="row justify-content-center text-center m-4">
		<input class="col-2" type="submit" value="modifier">
	</div>
</form>
<a class="btn btn-dark" href="listeEtudiant.php?nomcl=<?php echo $ligne['nom']; ?>">Revenir à la page précédente !</a>

<?php
}
if(isset($_POST['titre'])){
	if($_POST['titre']!="" and $_POST['note']!="" and $_POST['etabli']!="" and $_POST['lieu']!="" and $_POST['ann_obt']!=""){
		$id=$_POST['id'];
		$numdip=addslashes(Htmlspecialchars($_POST['titre']));
		$note=addslashes(Htmlspecialchars($_POST['note']));
		$lieu=addslashes(Htmlspecialchars($_POST['lieu']));
		$etabli=addslashes(Htmlspecialchars($_POST['etabli']));
		$comment=addslashes(Htmlspecialchars($_POST['comment']));
		$annee=addslashes(Htmlspecialchars($_POST['ann_obt']));
		mysqli_query($conn, "update eleve_diplome set numdip='$numdip', lieu='$lieu', etablissement='$etabli', commentaire='$comment', note='$note', annee_obtention='$annee' where id='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succès!"); </SCRIPT> 
		<?php
	}
	else{
	?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champss"); </SCRIPT> <?php
	}
	echo '<a class="btn btn-dark" href="modif_diplome.php?modif_dip='.$id.'">Revenir à la page precedente !</a>';
}
if(isset($_GET['supp_dip'])){
$id=$_GET['supp_dip'];
mysqli_query($conn, "delete from eleve_diplome where id='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!"); </SCRIPT> <?php
echo '<a class="btn btn-dark" href="index.php?">Revenir à la page principale !</a>';
}
?>
</div>
