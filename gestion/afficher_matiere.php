<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
      <img src="titre_img/affich_matiere.png" class="position_titre">
  </div>
<?php if(isset($_GET['nomcl'])){
$_SESSION['nomcl']=$_GET['nomcl'];
$nomcl=$_GET['nomcl'];
$data=mysqli_query($conn, "select promotion from classe where nom='$nomcl' order by promotion desc");
?>
<form method="post" action="afficher_matiere.php" class="form container">
   <div class="row justify-content-center m-4">
      <h3 class="text-center">Veuillez choisir la promotion et le semestre pour <?php echo $nomcl; ?></h3>
   </div>
   <h3 class="text-center">Critères d'affichage</h3>
   <div class="row justify-content-around">
      <div class="col-5 justify-content-center m-4 flex-column align-items-center text-center">
         <label class="col-4" for="">Promotion:</label>
         <select class="col-4" name="promotion"> 
         <?php while($a=mysqli_fetch_array($data)){
         echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
         }?></select>
      </div>
      <div class="col-5 justify-content-center m-4 flex-column align-items-center text-center">
         <label class="col-4" for="">Semestre:</label>
         <select class="col-4" name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
         </select>
      </div>
   </div>
   <div class="row justify-content-center m-4">
      <input class="btn btn-dark col-3" type="submit" value="Afficher les matieres">
   </div>
</form>
<a class="btn btn-dark" href="index.php">Revenir à la page principale</a>
<?php }  ?>
<?php
if(isset($_POST['radiosem'])){
$nomcl=$_SESSION['nomcl'];
$semestre=$_POST['radiosem'];
$promo=$_POST['promotion'];
$donnee=mysqli_query($conn, "select matiere.codemat,nommat,classe.nom,numsem,prof.nom as nomprof from matiere,enseignement,classe,prof where matiere.codemat=enseignement.codemat and prof.numprof=enseignement.numprof and enseignement.codecl=classe.codecl and classe.nom='$nomcl' and enseignement.numsem='$semestre' and promotion='$promo'");
?>
<?php   
	if (mysqli_num_rows($donnee)==0){
      $_SESSION["r_vide"] = "Aucune correspendance trouvée";
         echo $_SESSION["r_vide"];
      } 
?>
<table id="rounded-corner" class="table table-striped table-hover table-bordered"><thead>
<tr><?php echo Edition(); ?>
<th class="<?php echo rond(); ?>">Matière</th>
<th class="rounded-q2">Classe</th>
<th class="rounded-q2">Nom prof</th>
<th class="rounded-q4">Semestre</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(3,5); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
   <p>
   <?php
   while($a=mysqli_fetch_array($donnee)){
  if(isset($_SESSION['admin'])){ echo '<tr><td><a href="modif_matiere.php?modif_matiere='.$a['codemat'].'"><img src="/gestion/image/editer.png" class="img-fluid" style="width: 20px;" alt="modifier"></a></td><td><a href="modif_matiere.php?supp_matiere='.$a['codemat'].'" onclick="return(confirm(\'Etes-vous s�r de vouloir supprimer cette entr�e?\'));"><img src="/gestion/image/supprimer.png" class="img-fluid" style="width: 20px;" alt="supprimer"></a></td>'; } echo '<td>'.$a['nommat'].'</td><td >'.$a['nom'].'</strong></td><td>'.$a['nomprof'].'</td><td>S'.$a['numsem'].'</td></tr>';
   }
   ?>
   </p>
</tbody>
<tr></tr>
</table>
<?php 
echo '<br/><br/><a class="btn btn-dark" href="afficher_matiere.php?nomcl='.$nomcl.'">Revenir à la page principale</a>';
} ?>
</div>
<?php include ("../pages/footer.php"); ?>