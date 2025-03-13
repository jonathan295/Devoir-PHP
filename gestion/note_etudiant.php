<?php
include('cadre.php');
if(isset($_SESSION['etudiant'])){
$id=$_SESSION['etudiant'];
$data=mysqli_query($conn, "select bulletin.numel,nomel,prenomel,nommat,numsem,promotion,notefinal,nom from matiere,bulletin,eleve,classe where classe.codecl=eleve.codecl and bulletin.numel=eleve.numel and matiere.codemat=bulletin.codemat and eleve.numel='$id' order by numsem");
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/affich_stage.png" class="position_titre">
  </div>

<table id="rounded-corner" class="table table-striped table-hover table-bordered">
<thead><tr><th class="rounded-company">Nom</th>
<th class="rounded-q2">Prenom</th>
<th class="rounded-q2">Classe</th>
<th class="rounded-q2">Promotion</th>
<th class="rounded-q2">Matière</th>
<th class="rounded-q2">note final</th>
<th class="rounded-q4">Semestre</th></tr></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($data)){
echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nommat'].'</td><td>'.$a['notefinal'].'</td><td>S'.$a['numsem'].'</td></tr>';
}
?>
</tbody>
</table>
<div class="row justify-content-center">
    <a class="btn btn-dark" href="index.php">Revenir à la page précédente !</a>
</div>
</div>
<?php } ?>
</html>