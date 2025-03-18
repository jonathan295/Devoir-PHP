<?php
include('cadre.php');
include('calendrier.html');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/ajout_etudiant.png" class="position_titre">
  </div>


<?php
if(isset($_POST['nom'])){
	if($_POST['nom']!="" and $_POST['prenom']!="" and $_POST['date']!="" and $_POST['adresse']!="" and $_POST['phone']!="" and $_POST['pseudo']!="" and $_POST['mdp']!=""){
	$nom=addslashes(Htmlspecialchars($_POST['nom']));
	$prenom=addslashes(Htmlspecialchars($_POST['prenom']));
	$date=addslashes(Htmlspecialchars($_POST['date']));
	$phone=addslashes(Htmlspecialchars($_POST['phone']));
	$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
	$nomcl=$_POST['nomcl'];
	$promo=$_POST['promotion'];
	$pseudo=$_POST['pseudo'];
	$passe=$_POST['mdp'];
	$nb=mysqli_fetch_array(mysqli_query($conn,"select count(*) as nb from eleve where nomel='$nom' and prenomel='$prenom'"));
	if($nb['nb']!=0){
	?><SCRIPT LANGUAGE="Javascript">alert("erreur! cet enregistrement existe déjà!");</SCRIPT><?php
	}
	else{
	$data=mysqli_fetch_array(mysqli_query($conn,"select codecl from classe where nom='$nomcl' and promotion='$promo'"));
	$codecl=$data['codecl'];
	mysqli_query($conn,"insert into eleve(nomel,prenomel,date_naissance,adresse,telephone,codecl) values('$nom','$prenom','$date','$adresse','$phone','$codecl')");
	/*		Ajouter le num dans le login    */
	$numel=mysqli_fetch_array(mysqli_query($conn,"select numel from eleve where nomel='$nom' and prenomel='$prenom'"));
	$num=$numel['numel'];
	mysqli_query($conn,"insert into login(Num,pseudo,passe,type) values('$num','$pseudo','$passe','etudiant')");
	?>	<SCRIPT LANGUAGE="Javascript">alert("Ajout avec succès!");</SCRIPT> 	<?php
	}
	}
	else{
	?> 	<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");	</SCRIPT> 	<?php
	}
}
?>
<?php
$data=mysqli_query($conn,"select distinct promotion from classe order by promotion desc");
?>
<form action="Ajout_etudiant.php" method="POST" class="form">
	<h3 class="text-center">Ajouter un Etudiant</h3>  
	<div class="row justify-content-center m-4">
		<label class="col-2" for="">Nom étudiant:</label class="col-2">
		<input class="col-4" type="text" name="nom">
	</div>
	<div class="row justify-content-center m-4">
		<label class="col-2" for="">Prénom:</label class="col-2">
		<input class="col-4" type="text" name="prenom">
	</div>
	<div class="row justify-content-center m-4">
		<label class="col-2" for="">Date de naissance:</label class="col-2">
		<input class="col-4 calendrier" type="text" name="date">
	</div>
	<div class="row justify-content-center m-4">
		<label class="col-2" for="">Adresse:</label class="col-2">
		<input class="col-4" type="text" name="adresse">
	</div>
	<div class="row justify-content-center m-4">
		<label class="col-2" for="">Telephone:</label class="col-2">
		<input class="col-4" type="text" name="phone">
	</div>
	<div class="row justify-content-center m-4">
		<label class="col-2" for="">pseudo:</label class="col-2">
		<input class="col-4" type="text" name="pseudo">
	</div>
	<div class="row justify-content-center m-4">
		<label class="col-2" for="">mot de passe:</label class="col-2">
		<input class="col-4" type="password" name="mdp">
	</div>
	<div class="row justify-content-center">
		<div class="col-4 justify-content-center m-4 flex-column align-items-center border-white text-center">
			<label class="col-4" for="">Classe:</label class="col-2">
			<select class="col-4" name="nomcl"> 
			<?php 
			$retour=mysqli_query($conn,"select distinct nom from classe"); // afficher les classes
			while($a=mysqli_fetch_array($retour)){
			echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
			}?>
			</select>
		</div>
		<div class="col-4 justify-content-center m-4 flex-column align-items-center border-white text-center">
			<label class="col-4" for="">Promotion:</label class="col-2">
			<select class="col-4" name="promotion"> 
			<?php while($a=mysqli_fetch_array($data)){
			echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
			}?>
			</select>
		</div>
	</div>
	<div class="row justify-content-center m-4">
		<input class="btn btn-dark col-2" class="col-2" type="submit" value="Ajouter">
	</div>
</form>

</div>
<?php include ("../pages/footer.php"); ?>