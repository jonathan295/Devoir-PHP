<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/type_diplome.png" class="position_titre">
  </div>
<?php
$donnee=mysqli_query($conn,"select * from diplome");
?>
<table class="table table-hover table-striped table-bordered text-center" id="rounded-corner">
<thead><tr><?php if(isset($_SESSION['admin'])) echo '<th class="rounded-company">Supprimer</th>'; ?>
<th class="rounded-q1" >Titre du diplôme</th>
</tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(0,2); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '<td><a href="type_diplome.php?supp_type='.$a['numdip'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));"><img src="/gestion/image/supprimer.png" class="img-fluid" style="width: 20px;" alt="supprimer"></td>'; } echo '<td>'.$a['titre_dip'].'</td></tr>'; 
}
?>
</tbody>
</table>
<a class="btn btn-dark" href="index.php">Revenir à la page principale </a>
<?php
if(isset($_GET['supp_type'])){ 
$id=$_GET['supp_type'];
mysqli_query($conn,"delete from diplome where numdip='$id'"); }
?>
</div>
<?php include ("../pages/footer.php"); ?>