<?php
include('cadre.php');
include('calendrier.html');
echo '<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
  	<img src="titre_img/modif_enseign.png" class="position_titre">
  </div>';
if(isset($_GET['modif_ensein'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_ensein'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select classe.codecl,prof.numprof,promotion,classe.nom as nomcl,prenom,prof.nom as nomp,matiere.codemat,nommat,numsem from classe,matiere,enseignement,prof where classe.codecl=enseignement.codecl and matiere.codemat=enseignement.codemat and prof.numprof=enseignement.numprof and id='$id'"));
$prof=mysqli_query($conn, "select * from prof");
$mat=mysqli_query($conn, "select * from matiere");
?>
<form action="modif_enseign.php" method="POST" class="form">
	<div class="row justify-content-center text-center m-4">
		<label for="">Matière</label>
		<select class="col-3" name="codemat"> 
		<?php while($a=mysqli_fetch_array($mat)){
		echo '<option value="'.$a['codemat'].'" '.choixpardefault2($a['codemat'],$ligne['codemat']).'>'.$a['nommat'].'</option>';
		}?>
		</select>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Professeur</label>
		<select class="col-3" name="numprof"> 
		<?php while($a=mysqli_fetch_array($prof)){
		echo '<option value="'.$a['numprof'].'" '.choixpardefault2($a['numprof'],$ligne['numprof']).'>'.$a['nom'].' '.$a['prenom'].'</option>';
		}?>
		</select>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Classe</label>
		<p><?php echo stripslashes($ligne['nomcl']); ?></p>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Promotion</label>
		<p><?php echo $ligne['promotion']; ?></p>
	</div>
	<div class="row justify-content-center text-center m-4">
		<label for="">Semestre</label>
		<p><?php echo $ligne['numsem']; ?></p>
	</div>
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="hidden" name="codecl" value="<?php echo $ligne['codecl']; ?>">
	<input type="hidden" name="numsem" value="<?php echo $ligne['numsem']; ?>">
	<div class="row justify-content-center text-center m-4">
		<input class="btn btn-dark col-2" type="submit" value="MODIFIER">
	</div>
</form>
<?php
echo '<a class="btn btn-dark" href="afficher_devoir.php">Revenir à la page précédente !</a>';
}
if(isset($_POST['numprof'])){//s'il a cliquer sur le bouton modifier
	$id=$_POST['id'];
		$numprof=$_POST['numprof'];
		$codemat=$_POST['codemat'];
		$codecl=$_POST['codecl'];
		$numsem=$_POST['numsem'];
		$compte=mysqli_fetch_array(mysqli_query($conn, "select count(*) as nb from enseignement where numprof='$numprof' and codemat='$codemat' and codecl='$codecl'"));
		if($compte['nb']!=0){//deux devoir similaire()2 devoirs par matiere
		?> <SCRIPT LANGUAGE="Javascript">	alert("erreur de modification,cet enseignement existe déjà"); </SCRIPT> <?php
		}
		else{
		mysqli_query($conn, "update enseignement set numprof='$numprof',codemat='$codemat' where id='$id'");
		$suppression=mysqli_query($conn, "select * from devoir where codemat='$codemat' and codecl='$codecl' and numsem='$numsem'");//tres important()supprimier les devoir correspondants
		/*			Supprimer le devoir et l'evaluation correspondnt			*/
		while($a=mysqli_fetch_array($suppression)){
			$cle=$a['numdev'];
			mysqli_query($conn, "delete from evaluation where numdev='$cle'");
			mysqli_query($conn, "delete from devoir where numdev='$cle'");
		}
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succès!\ntous les entrés reliées à cet enregistrement en été supprimé"); </SCRIPT> <?php
		}
		
	echo '<a class="btn btn-dark" href="modif_enseign.php?modif_ensein='.$id.'">Revenir à la page precedente !</a>';
}
if(isset($_GET['supp_ensein'])){
$id=$_GET['supp_ensein'];
/* 		requete pour utiliser son retour afin de recuperer le numdev qu'on va supprimer aussi 		*/
$ligne=mysqli_fetch_array(mysqli_query($conn, "select classe.codecl,matiere.codemat,numsem from classe,matiere,enseignement where classe.codecl=enseignement.codecl and matiere.codemat=enseignement.codemat and id='$id'"));
$codemat=$ligne['codemat'];
$codecl=$ligne['codecl'];
$numsem=$ligne['numsem'];
$suppression=mysqli_query($conn, "select * from devoir where codemat='$codemat' and codecl='$codecl' and numsem='$numsem'");//tres important()supprimier les devoir correspondants
		/*			Supprimer le devoir et l'evaluation correspondnte			*/
		while($a=mysqli_fetch_array($suppression)){
			$cle=$a['numdev'];
			mysqli_query($conn, "delete from evaluation where numdev='$cle'");
			mysqli_query($conn, "delete from devoir where numdev='$cle'");
		}
mysqli_query($conn, "delete from enseignement where id='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!\ntous les entrés reliées à cet enregistrement on été supprimer"); </SCRIPT> <?php
echo '<a href="/gestion00/index.php">Revenir à la page principale</a>'; //on revient � la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</div>
<?php include ("../pages/footer.php"); ?>