<?php
include('cadre.php');
echo '<div class="corp">';
if(isset($_GET['matiere'])){
$id=$_GET['matiere'];
$data=mysqli_query($conn, "select prof.nom,prenom,nommat,classe.nom as nomcl,promotion,numsem from prof,enseignement,matiere,classe where enseignement.numprof=prof.numprof and classe.codecl=enseignement.codecl and matiere.codemat=enseignement.codemat and  enseignement.numprof='$id' order by promotion desc");
?>
<h1 class="text-center">Matieres enseignées par cet enseignant</h1>
<table id="rounded-corner" class="table table-striped table-hover table-bordered container">
<thead><tr> <th scope="col" class="rounded-company">Nom</th>
 <th scope="col" class="rounded-q2">Prenom</th>
 <th scope="col" class="rounded-q2">Matière</th>
 <th scope="col" class="rounded-q2">Classe</th>
 <th scope="col" class="rounded-q2">Promotion</th>
 <th scope="col" class="rounded-q4">Semestre</th></tr></thead>
<tfoot>
<tr>
<td colspan="5"class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($data)){
echo '<tr><td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['nommat'].'</td><td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['numsem'].'</td></tr>';
}
?>
<tbody>
</table>
<div class="container d-flex justify-content-center">
    <a class="btn btn-dark" href="/gestion00/gestion/afficher_prof.php">Revenir à la page précédente !</a>
</div>

<?php 
}
else if(isset($_GET['classe'])){
$id=$_GET['classe'];
$data=mysqli_query($conn, "select * from prof,classe where numprof=numprofcoord and numprof='$id' order by promotion desc");
?>
<h1 class="text-center">Classe coordonées par cet enseignant</h1>
<table id="rounded-corner" class="table table-striped table-hover table-bordered container">
<thead><tr> <th scope="col" class="rounded-company">Nom</th>
 <th scope="col" class="rounded-q2">Prenom</th>
 <th scope="col" class="rounded-q2">Classes coordonées</th>
 <th scope="col" class="rounded-q4">Promotion</th></tr></thead>
<tfoot>
<tr>
<td colspan="3" class="rounded-foot-left">&nbsp;</td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($data)){
echo '<tr><td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td></tr><tr></tr>';
}
?>
<tbody>
</table>
<div class="container d-flex justify-content-center">
    <a class="btn btn-dark" href="/gestion00/gestion/afficher_prof.php">Revenir à la page précédente !</a>
</div>
<?php
}
?>
</div>