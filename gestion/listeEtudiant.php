<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/affich_eleve.png" class="position_titre">
  </div>

<?php if(isset($_GET['nomcl'])) : //affichage de la promotion ?>
  <?php $nomcl=$_GET['nomcl'];
  $_SESSION['nomcl']=$_GET['nomcl'];//session du nomcl choisis dans le menu pour laisser la variable jusqu'a la page ou on va afficher la liste
  $data=mysqli_query($conn, "select promotion from classe where nom='$nomcl' order by promotion desc");
  ?>
  <form action="listeEtudiant.php" method="POST" class="form text-center">
    <h3 class="text-center">Veuilliez choisir la Promotion pour la classe <?php echo $_GET['nomcl']; ?>:</h3>
    <div class="row m-4 justify-content-center flex-column align-items-center">
      <label class="form-label col-2">Promotion </label>
      <select class="col-4" name="promotion"> 
        <?php while($a=mysqli_fetch_array($data)){
        echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
        }?>
      </select>
    </div>
    <div class="row m-4 justify-content-center">
      <input class="btn btn-blue col-2" type="submit" value="AFFICHER">
    </div>
  </form>
  <div class="row m-4 justify-content-center">
    <a class="btn btn-dark" href="index.php?">Revenir à la page précédente !</a>
  </div>
  
<?php endif; ?>
<?php 
if(isset($_POST['promotion'])){
$nomcl=$_SESSION['nomcl'];
$promo=$_POST['promotion'];
$donnee=mysqli_query($conn, "select numel,nomel,prenomel,date_naissance,adresse,telephone,eleve.codecl,nom,promotion from eleve,classe where eleve.codecl=classe.codecl and nom='$nomcl' and promotion='$promo'");
?>
<table class="table table-striped table-hover table-hover" id="rounded-corner">
<thead><?php echo Edition(); ?>
<th class="<?php echo rond();?>">Nom</th>
<th class="rounded-q2">Prenom</th>
<th class="rounded-q2">Date de naissance</th>
<th class="rounded-q2">Adresse</th>
<th class="rounded-q2">Telephone</th>
<th class="rounded-q2">Classe</th>
<th class="rounded-q2">Promotion</th>
<th class="rounded-q4">Ses enseignants</th></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(7,9); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
// $a=mysqli_fetch_array($donnee);
// print_r($a);
while($a=mysqli_fetch_array($donnee)){
?>
<tr><?php if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])){
echo '<td><a href="modif_eleve.php?modif_el='.$a['numel'].'"><img src="/gestion/image/editer.png" alt="modifier" style="width: 20px;"></a></td><td><a href="modif_eleve.php?supp_el='.$a['numel'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\ntous les enregistrements en relation avec cette entrée seront perdus\'));"><img src="/gestion/image/supprimer.png" alt="supprimer" style="width: 20px;"></a></td>';}
echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['date_naissance'].'</td><td>'.$a['adresse'].'</td><td>'.$a['telephone'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td><a href="listeEtudiant.php?voir_ensei='.$a['numel'].'" class="d-flex justify-content-center"><img src="/gestion/image/oeil.png" class="img-fluid" style="width: 20px;" alt="voir enseignant"></a></td></tr>';
}
?>
<tbody>
</table class="table table-striped table-hover table-hover">
<?php
echo '<a class="btn btn-dark" href="listeEtudiant.php?nomcl='.$nomcl.'">Revenir à la page précédente !</a>';
}
if(isset($_GET['voir_ensei'])){
$id=$_GET['voir_ensei'];
$data=mysqli_query($conn, "select prof.nom,prenom,nomel,nomel,classe.nom as nomcl,numsem,nommat,prof.adresse,promotion from prof,matiere,classe,eleve,enseignement where prof.numprof=enseignement.numprof and enseignement.codemat=matiere.codemat and eleve.codecl=classe.codecl and classe.codecl=enseignement.codecl and numel='$id'");
?>
<h2>Les enseignants de l'étudiant choisis : </h2><br/>
<table class="table table-striped table-hover table-hover" id="rounded-corner">
<thead><th class="rounded-company">Nom d'etudiant</th>
<th class="rounded-q2">nom</th>
<th class="rounded-q2">Classe</th>
<th class="rounded-q2">promotion</th>
<th class="rounded-q2">Nom et nom d'enseignant</th>
<th class="rounded-q2">Semestre</th>
<th class="rounded-q4">matiere</th></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($data)){
?>
<tr><?php
echo '<td>'.$a['nomel'].'</td><td>'.$a['nomel'].'</td><td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nom'].' '.$a['nom'].'</td><td>'.$a['numsem'].'</td><td>'.$a['nommat'].'</td></tr>';
}
?>
<tbody>
</table> 
<?php
}
?>
</div>
<?php include ("../pages/footer.php"); ?>