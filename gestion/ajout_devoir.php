<?php
include('cadre.php');
include('calendrier.html');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
   <div class="container d-flex align-items- justify-content-center">
   	<img src="titre_img/ajout_devoir.png" class="position_titre">
   </div>
<form action="ajout_devoir.php" method="POST" class="form">
<?php
if(isset($_POST['nomcl'])){
$_SESSION['nomcl']=$_POST['nomcl'];
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$promo;
$donnee=mysqli_query($conn, "select codemat,nommat from matiere,classe where matiere.codecl=classe.codecl and nom='$nomcl' and promotion='$promo'");
?>
	<h3 class="text-center">Ajouter un devoir</h3>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Matière</label>
		<select class="col-2" name="choix_mat" id="choix">
			<?php while($a=mysqli_fetch_array($donnee)){echo '<option value="'.$a['codemat'].'">'.$a['nommat'].'</option>';}?>
		</select>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Date du devoir</label>
		<input class="col-2 calendrier" type="text" name="date">
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Coefficient</label>
		<select class="col-2" name="coefficient"><?php for($i=1;$i<=15;$i++){ echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
		</select>
	</div>
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Semestre</label>
		<select class="col-2" name="semestre"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
		</select>
	</div>
	<div class="row justify-content-center text-center m-4">
		<h3 for="">1er / 2ème Devoir</h3>
		<div class="col-2 justify-content-center text-center m-4">
			<input type="radio" name="devoir" value="1" id="choix1" /> 
			<label for="choix1">1er devoir</label>
		</div>
		<div class="col-2 justify-content-center text-center m-4">
			<input type="radio" name="devoir" value="2" id="choix2" /> 
			<label for="choix2">2eme devoir</label>
		</div>
	</div>
	<div class="row justify-content-center text-center m-4">
		<input class="btn btn-dark" type="submit" value="Ajouter">
	</div>
</form>
<?php }
else if(isset($_POST['date'])){//s'il a cliquer sur ajouter la 2eme fois
$date=addslashes(Nl2br(Htmlspecialchars($_POST['date'])));
$coefficient=$_POST['coefficient'];
$semestre=$_POST['semestre'];
$codemat=$_POST['choix_mat'];
$nomcl=$_SESSION['nomcl'];
$n_devoir=$_POST['devoir'];//Premier ou 2eme devoir -- 1 ou 2
$promo=$_SESSION['promo'];
/*
 pour ne pas ajouter deux controles similaire
 */
$data=mysqli_query($conn, "select count(*) as nb from devoir where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and codemat='$codemat' and numsem='$semestre' and n_devoir='$n_devoir'");
/*
 pour verifier si l'enseignemet (codecl,nommat,numsem) existe ou  pas
 */
$valider=mysqli_query($conn, "select count(*) as nb from enseignement where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and codemat='$codemat' and numsem='$semestre'");

$nb=mysqli_fetch_array($data);

$nb2=mysqli_fetch_array($valider);

$bool=true;

	/*
	pour verifier si l'enseignemet (codecl,nommat,numsem) existe ou  pas
	*/
	if($nb2['nb']!=0){
		$bool=false;
		echo '<br\><h2>Erreur d\'insertion!! Cet enseignement n\'existe pas </h2>';
	}
	/*
	pour ne pas ajouter deux controles similaire
	*/
	if($nb['nb']>0){
		$bool=false;
		echo '<br\><h2>Erreur d\'insertion!! N° de devoir incorrect(impossible d\'ajouter deux devoirs similaires)</h2>';
	}
	if($bool==true){
	$codeclasse=mysqli_query($conn, "select codecl from classe where nom='$nomcl' and promotion='$promo'");
	$code=mysqli_fetch_array($codeclasse);
	$codecl=$code['codecl'];
	mysqli_query($conn, "insert into devoir(date_dev,coeficient,codemat,codecl,numsem,n_devoir) values('$date','$coefficient','$codemat','$codecl','$semestre','$n_devoir')");
	echo '<h1>Insertion avec succès </h1>';
	}
}
 else {
 $retour=mysqli_query($conn, "select distinct nom from classe"); 
 $data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
 ?>
<form action="ajout_devoir.php" method="POST" class="form">
    <h3 class="text-center">Classe/promotion</h3> 
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Promotions</label>
		<select class="col-2" name="promotion"> 
		<?php while($a=mysqli_fetch_array($data)){
		echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
		}?></select>
	</div> 
	<div class="row justify-content-center flex-column align-items-center text-center m-4">
		<label for="">Classe</label>
		<select class="col-2" name="nomcl"> 
		<?php while($a=mysqli_fetch_array($retour)){
		echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
		}?></select>
	</div> 
	<div class="row justify-content-center text-center m-4">
		<input class="btn btn-dark col-2" type="submit" value="Suivant">
	</div>
</form>
<?php } ?>
<?php include ("../pages/footer.php"); ?>
