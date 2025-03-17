<?php
include('cadre.php');
?>
<?php if(isset($_GET['ajout_type'])){ ?>
<div class="container d-flex align-items- justify-content-center flex-column">
	<div class="container d-flex align-items- justify-content-center">
		<img src="titre_img/ajout_diplome.png" class="position_titre">
	</div>
	<form action="ajout_diplome.php" method="POST" class="form">
		<h3 class="text-center">Veuillez saisir le titre du diplôme à ajouter</h3>
		<div class="row justify-content-center m-4 flex-column align-items-center text-center">
			<label class="col-4" for="">Titre du diplôme</label>
			<input class="col-4" type="text" name="ajout_titre">
		</div>
		<div class="row justify-content-center m-4 text-center">
			<input class="btn btn-dark col-2" class="btn btn-dark col-2" type="submit" value="Ajouter">
		</div>
	</form>
<?php
}
else if(isset($_GET['ajout_diplome'])){ 
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");//select pour les promotions
$nomclasse=mysqli_query($conn, "select distinct nom from classe");
 ?>
<div class="container d-flex align-items- justify-content-center flex-column">
	<div class="container d-flex align-items- justify-content-center">
		<img src="titre_img/ajout_diplome.png" class="position_titre">
	</div>
<form action="ajout_diplome.php" method="POST" class="form">
	<h3 class="text-center">Veuillez choisir la classe et la promotion</h3>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Promotion</label>
		<select class="col-2" name="promotion"> 
		<?php while($a=mysqli_fetch_array($data)){
		echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
		}?></select>
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Classe</label>
		<select class="col-2" name="nomcl"> 
		<?php while($a=mysqli_fetch_array($nomclasse)){
		echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
		}?></select>
	</div>
	<div class="row justify-content-center m-4 text-center">
		<input class="btn btn-dark col-2" class="btn btn-dark col-2" type="submit" value="Suivant">
	</div>
</form>
<?php }
else if(isset($_POST['nomcl'])){ 
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$data=mysqli_query($conn, "select numel,nomel,prenomel from eleve where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo')");
$titre=mysqli_query($conn, "select numdip,titre_dip from diplome");
?>
<div class="container d-flex align-items- justify-content-center flex-column">
	<div class="container d-flex align-items- justify-content-center">
		<img src="titre_img/ajout_diplome.png" class="position_titre">
	</div>
<form action="ajout_diplome.php" method="POST" class="form">
	<h3 class="text-center">Veuillez remplire les informations</h3>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Etudiant</label>
		<select class="col-2" name="numel"> 
		<?php while($a=mysqli_fetch_array($data)){
		echo '<option value="'.$a['numel'].'">'.$a['nomel'].' '.$a['prenomel'].'</option>';
		}?></select>
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Titre du diplôme</label>
		<select class="col-2" name="titre"><?php while($var=mysqli_fetch_array($titre)){  
		echo '<option value="'.$var['numdip'].'">'.$var['titre_dip'].'</option>'; 
		} ?></select>
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Note</label>
		<input class="col-4" type="text" name="note">
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Commentaire</label>
		<input class="col-4" type="text" name="comment">
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Etablissement</label>
		<input class="col-4" type="text" name="etabli">
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Lieu</label>
		<input class="col-4" type="text" name="lieu">
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<label class="col-4" for="">Année d'obtention</label>
		<input class="col-4" type="text" name="ann_obt">
	</div>
	<div class="row justify-content-center m-4 text-center">
		<input class="btn btn-dark col-2" class="btn btn-dark col-2" type="submit" value="Ajouter">
	</div>
</form>
<?php
}
else if(isset($_POST['numel'])){
if($_POST['note']!="" and $_POST['lieu']!="" and $_POST['comment']!="" and $_POST['etabli']!="" and $_POST['ann_obt']!=""){
	$note=str_replace(',','.',$_POST['note']);
	$comment=addslashes(Htmlspecialchars($_POST['comment']));
	$etabli=addslashes(Htmlspecialchars($_POST['etabli']));
	$annee=addslashes(Htmlspecialchars($_POST['ann_obt']));
	$lieu=addslashes(Nl2br(Htmlspecialchars($_POST['lieu'])));
	$numel=$_POST['numel'];
	$numdip=$_POST['titre'];
	echo 'numel--> '.$numel;
	$nb=mysqli_fetch_array(mysqli_query($conn, "select count(*) as nb from eleve_diplome where numel='$numel'"));
		if($nb['nb']!=0){
			?><SCRIPT LANGUAGE="Javascript">alert("erreur! cet enregistrement existe déjà!");</SCRIPT><?php
		}
		else{
		mysqli_query($conn, "insert into eleve_diplome(numdip,numel,note,commentaire,etablissement,lieu,annee_obtention) values('$numdip','$numel','$note','$comment','$etabli','$lieu','$annee')");
		?>	<SCRIPT LANGUAGE="Javascript">alert("Ajout avec succès!");</SCRIPT> 	<?php
		}
}
else {
?> 	<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");	</SCRIPT> 	<?php
}
echo '<br/><br/><a href="ajout_diplome.php?ajout_diplome">Revenir à la page précédente !</a>';
}
else if(isset($_POST['ajout_titre'])){
	$titre=$_POST['ajout_titre'];
	$nb=mysqli_fetch_array(mysqli_query($conn, "select count(*) as nb from diplome where titre_dip='$titre'"));
	if($nb['nb']!=0){
	?><SCRIPT LANGUAGE="Javascript">alert("erreur! cet enregistrement existe déjà!");</SCRIPT><?php
	}
	else{
	mysqli_query($conn, "insert into diplome(titre_dip) values('$titre')");
	?>	<SCRIPT LANGUAGE="Javascript">alert("Ajout avec succès!");</SCRIPT> 	<?php
	}
	echo '<a class="btn btn-dark" href="ajout_diplome.php?ajout_type">Revenir à la page précédente !</a>';
}


?>