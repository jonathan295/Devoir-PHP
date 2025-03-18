<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/ajout_classe.png" class="position_titre">
  </div>
<?php
if(isset($_POST['numprof'])){//s'il a cliquer sur ajouter la 2eme fois
$nomcl=$_POST['nomcl'];
$numprof=$_POST['numprof'];
$promo=$_POST['promotion'];
$compte=mysqli_fetch_array( mysqli_query($conn,"select count(*) as nb from classe where nom='$nomcl' and promotion='$promo'"));
$bool=true;
if($compte['nb']>0){
$bool=false;
echo '<h2>Erreur d\'insertion, l\'enregistrement existe déjà </h2>';
}
if($bool==true){
mysqli_query($conn,"insert into classe(nom,numprofcoord,promotion) values ('$nomcl','$numprof','$promo')");
?> <SCRIPT LANGUAGE="Javascript">	alert("Ajouté avec succès!"); </SCRIPT> <?php
}
echo '<br/><a class="btn btn-dark" href="ajout_classe.php">Revenir à la page précédente !</a>';
}
else {
$data=mysqli_query($conn,"select numprof,nom from prof");//select pour les promotions
 ?>
 <form action="ajout_classe.php" method="POST" class="form">
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label class="col-8" for="">Nom classe:</label class="col-8">
        <input class="col-8" type="text" name="nomcl">
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label class="col-8" for="">Promotion:</label class="col-8">
        <input class="col-8" type="text" name="promotion">
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label class="col-8" for="">Prof coordinataire:</label class="col-8">
        <select class="col-4" name="numprof"> <br/><br/>
        <?php while($a=mysqli_fetch_array( $data)){
        echo '<option value="'.$a['numprof'].'">'.$a['nom'].'</option>';
        }?></select>
    </div>
    <div class="row justify-content-center m-4 text-center">
        <input class="btn btn-dark col-2" type="submit" value="Ajouter">
    </div>
</form>
<a class="btn btn-dark" href="index.php">Revenir à la page principale !</a>
</div>
</pre></center>
<?php
}
?>
</div>
</div>
<?php include ("../pages/footer.php"); ?>