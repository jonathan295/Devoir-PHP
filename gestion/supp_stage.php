<?php

include('cadre.php');

?>
<html>
<div class="corp">
<h1 class="text-center">Supression du stage</h1>
<div class="formulaire">
<?php
if(isset($_GET['supp_stage'])){
$id=$_GET['supp_stage'];
mysqli_query($conn, "delete from stage where numstage='$id'");
echo '<h1>Suppression avec succes ! </h1>';
echo '<a class="btn btn-dark" href="index.php">Revenir à la page d\'accueill !</a>';
}
?>
</div>
</div>
<?php include ("../pages/footer.php"); ?>

