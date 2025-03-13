<?php
include('cadre.php');
$data=mysqli_query($conn,"select distinct promotion from classe order by promotion desc");
$retour=mysqli_query($conn,"select distinct nom from classe"); //pour afficher les classe existantes
?>
<html>
<body>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/affich_stage.png" class="position_titre">
  </div>
<?php
if(isset($_POST['nomcl']) and isset($_POST['promotion'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$donnee=mysqli_query($conn,"select numstage,nomel,prenomel,nom,promotion,date_debut,date_fin,lieu_stage from eleve,stage,classe where classe.codecl=eleve.codecl and eleve.numel=stage.numel and classe.nom='$nomcl' and promotion='$promo'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
?>
<table id="rounded-corner" class="table table-striped table-bordered table-hover">
<thead><tr><?php echo Edition(); ?>
<th class="<?php echo rond(); ?>">Nom de l'etudiant</th>
<th class="rounded-q2">Prenom</th>
<th class="rounded-q2">Classe</th>
<th class="rounded-q2">Promotion</th>
<th class="rounded-q2">date de debut</th>
<th class="rounded-q2">date de fin</th>
<th class="rounded-q4">lieu_stage</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(6,8); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '<td><a href="ajout_stage.php?modif_stage='.$a['numstage'].'" >modifier</a></td><td><a href="supp_stage.php?supp_stage='.$a['numstage'].'" onclick="return(confirm(\'Etes-vous s�r de vouloir supprimer cette entr�e?\'));">Supprimer</td>'; } echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['date_debut'].'</td><td>'.$a['date_fin'].'</td><td>'.$a['lieu_stage'].'</td></tr>'; //style="width:100px; height:22px; background-image: url(\'ajouter.png\'); color:red;  padding: 2px 0 2px 20px; display:block; background-repeat:no-repeat;"
}
?>
</tbody>
</table>
<?php
}//fin   if(isset($_POST['radio']
else{ ?>

<form method="post" action="afficher_stage.php" class="form">
    <div class="row justify-content-center m-4">
        <h3 class="text-center">Veuillez choisir la classe et la promotion:</h3>
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label class="col-4" for="">Promotion:</label class="col-4">
        <select class="col-4" name="promotion"> 
        <?php while($a=mysqli_fetch_array($data)){
        echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
        }?>
        </select>
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label class="col-4" for="">Classe:</label class="col-4">
        <select class="col-4" name="nomcl"> 
        <?php while($a=mysqli_fetch_array($retour)){
        echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
        }?>
        </select>
    </div>
    <div class="row justify-content-center m-4">
        <input class="btn btn-dark col-3" type="submit" value="Afficher les stages">
    </div>
</form>
<?php }
?>
<a class="btn btn-dark" href="afficher_stage.php">Revenir à la page précédente !</a>
</div>
</body>
</html>