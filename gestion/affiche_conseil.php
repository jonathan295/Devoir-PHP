<?php
include('cadre.php');
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
$retour=mysqli_query($conn, "select distinct nom from classe"); //pour afficher les classe existantes
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/affiche_conseil.png" class="position_titre">
  </div>
<?php
if(isset($_GET['supp_conseil'])){
$id=$_GET['supp_conseil'];
mysqli_query($conn, "delete from conseil where id='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprimé avec succès!"); </SCRIPT> <?php
}
else if(isset($_POST['nomcl']) and isset($_POST['numsem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$numsem=$_POST['numsem'];
$donnee=mysqli_query($conn, "select * from classe,conseil where classe.codecl=conseil.codecl and classe.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and numsem='$numsem'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'

if (mysqli_num_rows($donnee)==0){
    $_SESSION["r_vide"] = "Aucune correspendance trouvée";
      echo $_SESSION["r_vide"];
    }

?>
<table id="rounded-corner" class="table table-striped table-bordered table-hover">
<thead><tr><?php if(isset($_SESSION['admin'])) echo '<th class="rounded-company">Supprimer</th>'; ?>
<th class="<?php echo rond(); ?>">Semestre</th>
<th class="rounded-q4">Classe</th>
</tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(1,2); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '</td><td><a href="affiche_conseil.php?supp_conseil='.$a['id'].'" onclick="return(confirm(\'Etes-vous s�r de vouloir supprimer cette entrée?\'));"><img src="/gestion/image/supprimer.png" style="width: 20px;"></td>'; } echo '<td>S'.$a['numsem'].'</td><td>'.$a['nom'].'</td></tr>';
}
?>
<tr></tr>
</tbody>
</table>
<?php
}//fin   if(isset($_POST['radio']
else{ ?>

<form method="post" action="affiche_conseil.php" class="form container">
    <h3 class="text-center">Veuillez choisir la classe et la promotion :</h3>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label class="col-4" for="">Classe:</label>
        <select class="col-4" name="nomcl"> 
        <?php while($a=mysqli_fetch_array($retour)){
        echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
        }?></select>
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label class="col-4" for="">Promotion:</label>
        <select class="col-4" name="promotion"> 
        <?php while($a=mysqli_fetch_array($data)){
        echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
        }?></select>
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label class="col-4" for="">Semestre:</label>
        <select class="col-4" name="numsem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
        </select>
    </div>
    <div class="row justify-content-center m-4">
        <input class="btn btn-dark col-3" type="submit" value="Afficher les stages">
    </div>
</form>
<?php }
?>
<br/><br/><a class="btn btn-dark" href="affiche_conseil.php">Revenir à la page précédente !</a>
</div>
<?php include ("../pages/footer.php"); ?>