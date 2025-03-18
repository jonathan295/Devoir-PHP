<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/affich_prof.png" class="position_titre">
  </div>
<?php
$data=mysqli_query($conn, "select * from prof");
?>
<table id="rounded-corner" class="table table-striped table-hover table-bordered">
<thead><tr><?php echo Edition();?>
 <th scope="col" class="<?php echo rond(); ?>">Nom</th>
 <th scope="col" class="rounded-q2">Prenom</th>
 <th scope="col" class="rounded-q2">Adresse</th>
 <th scope="col" class="rounded-q2">Telephone</th>
 <th scope="col" class="rounded-q2">Matières enseignées</th>
 <th scope="col" class="rounded-q4">Classes coordonées</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(5,7); ?>"class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($data)){
?>
<?php if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])){
echo '<tr><td><a href="modif_prof.php?modif_prof='.$a['numprof'].' d-flex justify-content-center"><img src="/gestion00/image/editer.png" class="img-fluid" style="width: 20px;" alt="voir enseignant"></a></td><td><a href="modif_prof.php?supp_prof='.$a['numprof'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\')); d-flex justify-content-center"><img src="/gestion00/image/supprimer.png" class="img-fluid" style="width: 20px;" alt="voir enseignant"></a></a></td>';}
echo '<td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['adresse'].'</td><td>'.$a['telephone'].'</td><td class="text-center" ><a href="option_prof.php?matiere='.$a['numprof'].' class="d-flex justify-content-center"><img src="/gestion00/image/oeil.png" class="img-fluid" style="width: 20px;" alt="voir enseignant"></a><td class="text-center" ><a href="option_prof.php?classe='.$a['numprof'].' class="d-flex justify-content-center"><img src="/gestion00/image/oeil.png" class="img-fluid" style="width: 20px;" alt="voir enseignant"></a></tr>';
}
?>
<tbody>
</table>
<?php
echo '<a class="btn btn-dark" href="index.php">Revenir à la page précédente !</a>';
?>
<?php include ("../pages/footer.php"); ?>
