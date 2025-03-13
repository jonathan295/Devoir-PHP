<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/ajout_prof.png" class="position_titre">
  </div>
<?php
if(isset($_POST['adresse'])){//s'il a cliquer sur ajouter la 2eme fois
if($_POST['nom']!="" and $_POST['prenom']!="" and $_POST['adresse']!="" and $_POST['telephone']!="" and $_POST['pseudo']!="" and $_POST['passe']!=""){
$nom=addslashes($_POST['nom']);
$prenom=addslashes($_POST['prenom']);//Premier ou 2eme devoir -- 1 ou 2
$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
$telephone=$_POST['telephone'];
$pseudo=$_POST['pseudo'];
$passe=$_POST['passe'];
$compte=mysqli_fetch_array(mysqli_query($conn,"select count(*) as nb from prof where nom='$nom' and prenom='$prenom'"));// pour ne pas ajouter deux profs similaires
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">alert("erreur! Ce prof existe déjà ");</SCRIPT>
<?php
}
else{
mysqli_query($conn,"insert into prof(nom,prenom,adresse,telephone) values('$nom','$prenom','$adresse','$telephone')");
	/*		Ajouter le num dans le login    */
$numprof=mysqli_fetch_array(mysqli_query($conn,"select numprof from prof where nom='$nom' and prenom='$prenom'"));
$num=$numprof['numprof'];
mysqli_query($conn,"insert into login(Num,pseudo,passe,type) values('$num','$pseudo','$passe','prof')");
?><SCRIPT LANGUAGE="Javascript">alert("Insertion avec succès!");</SCRIPT>
<?php
}
}
else{
?>
<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");</SCRIPT>
<?php
}
echo '<br/><a href="ajout_prof.php">Revenir à la page précédente !</a>';
}
else {
 ?>
 <form action="ajout_prof.php" method="POST" class="form">
	<div class="row text-center justify-content-center m-4 flex-column align-items-center">
		<label class="col-6" for="">Nom:</label class="col-6">
		<input class="col-6" type="text" name="nom">
	</div>
	<div class="row text-center justify-content-center m-4 flex-column align-items-center">
		<label class="col-6" for="">Prenom:</label class="col-6">
		<input class="col-6" type="text" name="prenom">
	</div>
	<div class="row text-center justify-content-center m-4 flex-column align-items-center">
		<label class="col-6" for="">Adresse:</label class="col-6">
		<textarea class="col-6" name="adresse"> </textarea>
	</div>
	<div class="row text-center justify-content-center m-4 flex-column align-items-center">
		<label class="col-6" for="">Telephone:</label class="col-6">
		<input class="col-6" type="text" name="telephone">
	</div>
	<div class="row text-center justify-content-center m-4 flex-column align-items-center">
		<label class="col-6" for="">Pseudo:</label class="col-6">
		<input class="col-6" type="text" name="pseudo">
	</div>
	<div class="row text-center justify-content-center m-4 flex-column align-items-center">
		<label class="col-6" for="">Password:</label class="col-6">
		<input class="col-6" type="password" name="passe">
	</div>
	<div class="row text-center justify-content-center m-4 flex-column align-items-center">
		<input class="btn btn-dark col-2" type="submit" value="Ajouter">
	</div>
</form>
<?php
}
?>
</pre></center>
</div>
</html>
