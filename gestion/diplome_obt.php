<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/obt_diplome.png" class="position_titre">
  </div>
<?php
if(isset($_POST['nomcl']) and isset($_POST['promotion'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$donnee=mysqli_query($conn, "select id,titre_dip,nomel,prenomel,nom,promotion,note,commentaire,etablissement,lieu,annee_obtention from eleve,eleve_diplome,classe,diplome where diplome.numdip=eleve_diplome.numdip and classe.codecl=eleve.codecl and eleve.numel=eleve_diplome.numel and classe.nom='$nomcl' and promotion='$promo'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
?>
<table class="table table-hover table-striped table-bordered" id="rounded-corner">
<thead><tr><?php echo Edition(); ?>
<th class="<?php echo rond(); ?>">Nom</th>
<th class="rounded-q2">Prenom</th>
<th class="rounded-q2">Classe</th>
<th class="rounded-q2">Promo</th>
<th class="rounded-q2">Titre diplôme</th>
<th class="rounded-q2">Note</th>
<th class="rounded-q2">Commentaire</th>
<th class="rounded-q2">Etablissement</th>
<th class="rounded-q2">Lieu</th>
<th class="rounded-q4">Année obtention</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(9,11); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '<tr><td><a href="modif_diplome.php?modif_dip='.$a['id'].'" >modifier</a></td><td><a href="modif_diplome.php?supp_dip='.$a['id'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">Supprimer</td>'; } echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['titre_dip'].'</td><td>'.$a['note'].'</td><td>'.$a['commentaire'].'</td><td>'.$a['etablissement'].'</td><td>'.$a['lieu'].'</td><td>'.$a['annee_obtention'].'</td></tr>'; //style="width:100px; height:22px; background-image: url(\'ajouter.png\'); color:red;  padding: 2px 0 2px 20px; display:block; background-repeat:no-repeat;"
}
?>
</tbody>
<tr></tr>
</table>
<a class="btn btn-dark" href="diplome_obt.php">Revenir à la page precedente </a>
<?php
}//fin   if(isset($_POST['radio']
else{ 
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
$retour=mysqli_query($conn, "select distinct nom from classe");
?>
<form method="post" action="diplome_obt.php" class="form">
    <h3 class="text-center">Veuillez choisir la classe et la promotion</h3>
    <div class="row justify-content-center">
      <div class="col-4 justify-content-center m-4 flex-column align-items-center text-center">
          <label class="col-4" for="">Promotion</label>
          <select class="col-4" name="promotion"> 
          <?php while($a=mysqli_fetch_array($data)){echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';}?>
          </select>
      </div>
      <div class="col-4 justify-content-center m-4 flex-column align-items-center text-center">
          <label class="col-4" for="">Classe</label>
          <select class="col-4" name="nomcl"> 
          <?php while($a=mysqli_fetch_array($retour)){echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';}?></select>
      </div>
    </div>
    <div class="row justify-content-center m-4 text-center">
        <input class="btn btn-dark col-2" type="submit" value="Afficher les stages">
    </div>
</form>
<a class="btn btn-dark" href="index.php">Revenir à la page principale </a>
<?php }
?>
</div>
<?php include ("../pages/footer.php"); ?>