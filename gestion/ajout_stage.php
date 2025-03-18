<?php
include('cadre.php');
include('calendrier.html');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/ajout_stage.png" class="position_titre">
  </div>
<?php if(isset($_SESSION['modif_stage']) and isset($_POST['lieu'])){//si on a cliquer sur ajouter/modifier pour modifier le post pour ne pas entr
	if(!empty($_POST['lieu']) and !empty($_POST['date_debut']) and !empty($_POST['date_fin'])){
		$id=$_SESSION['modif_stage'];
	//	$numel=$_POST['numel'];
		$date_debut=$_POST['date_debut'];
		$date_fin=$_POST['date_fin'];
		$lieu=$_POST['lieu'];
		mysqli_query($conn,"update stage set lieu_stage='$lieu', date_debut='$date_debut', date_fin='$date_fin' where numstage='$id'");
		?> 	<SCRIPT LANGUAGE="Javascript">alert("Modification avec succes ! ");	</SCRIPT> 	<?php
		unset($_SESSION['modif_stage']);
			echo '<br/><br/><a class="btn btn-dark" href="index.php">Revenir à la page d\'accueill !</a>';

	}
	else{
			?> 	<SCRIPT LANGUAGE="Javascript">alert("Veuilliz remplir tous les champs ");	</SCRIPT> 	<?php
		}
}
else if(isset($_POST['lieu'])){		//s'il a cliquer sur ajouter /modifier la 2eme fois pour ajouter
if(!empty($_POST['lieu']) and !empty($_POST['date_debut']) and !empty($_POST['date_fin'])){
	$numel=$_POST['numel'];
	$date_debut=addslashes(Nl2br(Htmlspecialchars($_POST['date_debut'])));//Premier ou 2eme devoir -- 1 ou 2
	$date_fin=addslashes(Nl2br(Htmlspecialchars($_POST['date_fin'])));
	$lieu=addslashes(Nl2br(Htmlspecialchars($_POST['lieu'])));
	$compte=mysqli_fetch_array(mysqli_query($conn,"select count(*) as nb from stage where lieu_stage='$lieu' and numel='$numel' and date_debut='$date_debut' and date_fin='$date_fin'"));
	$bool=true;
	if($compte['nb']>0){
	$bool=false;
	?> 	<SCRIPT LANGUAGE="Javascript">alert("Erreur d\'insertion,le stage existe déjà!");	</SCRIPT> 	<?php
	}
	if($bool==true){
	mysqli_query($conn,"insert into stage(lieu_stage,date_debut,date_fin,numel) values ('$lieu','$date_debut','$date_fin','$numel')");
		?>	<SCRIPT LANGUAGE="Javascript">alert("Ajouté avec succès!");</SCRIPT> 	<?php
	}
	echo '<a class="btn btn-dark" href="index.php">Revenir à la page d\'accueill !</a>';
}
else{
?> 	<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");	</SCRIPT> 	<?php
echo '<a class="btn btn-dark" href="index.php">Revenir à la page d\'accueill !</a>';
}
}
else if(!isset($_POST['nomcl']) and !isset($_GET['modif_stage'])){
	$data=mysqli_query($conn,"select distinct promotion from classe order by promotion desc");//select pour les promotions
	$retour=mysqli_query($conn,"select distinct nom from classe");
 ?>
<form action="ajout_stage.php" method="POST" class="form">
	<h3 class="text-center">Veuillez choisir la classe et la promotion:</h3>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<lablel class="col-4" for="">Promotion:</lablel class="col-4">
		<select class="col-4" name="promotion"> 
		<?php while($a=mysqli_fetch_array($data)){
		echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
		}?>
		</select>
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<lablel class="col-4" for="">Classe:</lablel class="col-4">
		<select class="col-4" name="nomcl"> 
		<?php while($a=mysqli_fetch_array($retour)){
		echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
		}?>
		</select>
	</div>
	<div class="row justify-content-center m-4 text-center">
		<input class="col-2 btn btn-dark" type="submit" value="Suivant">
	</div>
</form>
<?php }
if((isset($_POST['nomcl']) and isset($_POST['promotion'])) or isset($_GET['modif_stage'])){// si on a cliquer sur suivant ou sur modifier
$id="";
$lieu="";
$date_debut="";
$date_fin="";
if(isset($_GET['modif_stage'])){// si c'est une modification
$id=$_GET['modif_stage'];
$_SESSION['modif_stage']=$id;
$donnee=mysqli_fetch_array(mysqli_query($conn,"select * from stage where numstage='$id'")); //	On selectione les champ qu'on va modifier dans la table stage
$lieu=$donnee['lieu_stage'];
$date_debut=$donnee['date_debut'];
$date_fin=$donnee['date_fin'];
$data=mysqli_fetch_array(mysqli_query($conn,"select numel,nomel,prenomel from eleve where numel=(select numel from stage where numstage='$id')"));// 	on reselectionne le numel pour que �a soit similaire � la requete de l'ajout
}
else{//si c 'est l'ajout
	$_SESSION['promo']=$_POST['promotion'];//pour l'envoyer la 2eme fois 
	$promo=$_POST['promotion'];
	$nomcl=$_POST['nomcl'];
$data=mysqli_query($conn,"select numel,nomel,prenomel from eleve,classe where classe.codecl=eleve.codecl and nom='$nomcl' and promotion='$promo'");
}
?>
<form action="ajout_stage.php" method="POST" class="form">
	<div class="row justify-content-center m-4">
		<lablel class="col-1" for="">Eleve:</lablel class="col-4">
		<?php if(isset($_GET['modif_stage'])){echo $data['nomel'].' '.$data['prenomel'];}else{
		?> <select class="col-2" name="numel"> 
		<?php while($a=mysqli_fetch_array($data)){
		echo '<option value="'.$a['numel'].'">'.$a['nomel'].' '.$a['prenomel'].'</option>';
		}?></select>
		<?php } ?>
	</div>
	<div class="row justify-content-center m-4 flex-column align-items-center text-center">
		<lablel class="col-4" for="">Lieu de stage</lablel class="col-4">
		<input class="col-8" type="text" name="lieu" value="<?php echo $lieu; ?>">
	</div>
	<div class="row justify-content-center">
		<div class="col-4 justify-content-center m-4 flex-column align-items-center text-center">
			<lablel class="col-4" for="">Date de debut</lablel class="col-4">
			<input class="col-4 calendrier" type="text" name="date_debut" value="<?php echo $date_debut; ?>">
		</div>
		<div class="col-4 justify-content-center m-4 flex-column align-items-center text-center">
			<lablel class="col-4" for="">Date de fin</lablel class="col-4">
			<input class="col-4 calendrier" type="text" name="date_fin" value="<?php echo $date_fin; ?>">
		</div>
	</div>
	<div class="row justify-content-center m-4 text-center">
		<input class="btn btn-dark col-2" type="sublit" value="Ajouter">
	</div>
</form>
<?php } ?>
</div>
<?php include ("../pages/footer.php"); ?>
