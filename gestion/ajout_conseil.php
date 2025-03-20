<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/ajout_conseil.png" class="position_titre">
  </div>
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$semestre=$_POST['radiosem'];
$code_classe=mysqli_fetch_array(mysqli_query($conn, "select codecl from classe where nom='$nomcl' and promotion='$promo'"));
$codecl=$code_classe['codecl'];


$compte=mysqli_fetch_array(mysqli_query($conn, "select count(*) as nb from conseil where numsem='$semestre' and codecl='$codecl'"));
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">alert("erreur! Ce conseil existe déjà ");</SCRIPT>
<?php
}
else{
mysqli_query($conn, "insert into conseil(numsem,codecl) values ('$semestre','$codecl')");
/*
 a la veille de chaque conseil de classe :   on suppose qu'un etudiant passe 2 devoir dans la m�me mati�re dans un semestre,on specifie le semestre dans la requete,alors si on regroup par numel et codemat on va trouver au max 2 notes
*/
$bulletin=mysqli_query($conn, "select eleve.numel,matiere.codemat,avg(note) as moyen from eleve,devoir,matiere,evaluation,classe where matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and devoir.numdev=evaluation.numdev and evaluation.numel=eleve.numel and devoir.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and numsem='$semestre' group by numel,matiere.codemat");
while($b=mysqli_fetch_array($bulletin)){
$numel=$b['numel'];
$codemat=$b['codemat'];
$notef=$b['moyen'];
mysqli_query($conn, "insert into bulletin(numsem,numel,codemat,notefinal) values('$semestre','$numel','$codemat','$notef')");
}
?>	<SCRIPT LANGUAGE="Javascript">alert("Ajouté avec succès!");</SCRIPT> 	<?php
}
?>
<a class="btn btn-dark" href="ajout_conseil.php">Revenir à la page précédente !</a>
</form>

<?php
}
else {
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
$retour=mysqli_query($conn, "select distinct nom from classe"); // afficher les classes
?>
<form method="post" action="ajout_conseil.php" class="form">
    <div class="row justify-content-center m-4 text-center">
        <h3 class="text-center">Veuillez choisir le Semestre, la promotion et la classe</h3>
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label for="">Promotion</label>
        <select class="col-4" name="promotion"> 
            <?php while($a=mysqli_fetch_array($data)){echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';}?>
        </select>
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label for="">Classe</label>
        <select class="col-4" name="nomcl"> 
            <?php while($a=mysqli_fetch_array($retour)){echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>'; }?>
        </select>
    </div>
    <div class="row justify-content-center m-4 flex-column align-items-center text-center">
        <label for="">Semestre</label>
        <select class="col-4" name="radiosem">
            <?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
        </select>
    </div>
    <div class="row justify-content-center m-4 text-center">
        <input class="col-4 btn btn-dark" type="submit" value="Valider le conseil">
    </div>
</form>
<?php } ?>
</div>
<?php include ("../pages/footer.php"); ?>