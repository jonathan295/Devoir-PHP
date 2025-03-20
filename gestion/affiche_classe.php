<?php
include('cadre.php');
?>
<div class="container d-flex align-items- justify-content-center flex-column">
  <div class="container d-flex align-items- justify-content-center">
    <img src="titre_img/affich_classe.png" class="position_titre">
  </div>


<?php
$data=mysqli_query($conn, "select codecl,classe.nom as nomcl,promotion,prof.nom as nomprof from classe,prof where classe.numprofcoord=prof.numprof");
?>
<table id="rounded-corner" class="table table-striped table-hover table-bordered">
<thead><tr><?php echo Edition();?>
 <th class="<?php echo rond(); ?>">Nom de la classe</th>
 <th class="rounded-q1">Promotion</th>
 <th class="rounded-q4">Prof coordinataire</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(2,4); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array( $data)){
?>
    <?php if(isset($_SESSION['admin'])){ ?>
        <tr>
        <td><a href="modif_classe.php?modif_classe=<?php echo $a['codecl']; ?>"><img src="/gestion/image/editer.png" style="width: 20px;" alt=""></a></td>
        <td><a href="modif_classe.php?supp_classe=<?php echo $a['codecl']; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette entrée?\ntous les enregistrements en relation avec cette entrée seront perdus'));"><img src="/gestion/image/supprimer.png" style="width: 20px;" alt=""></a></td> <?php }
echo '<td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nomprof'].'</td>
</tr>';
}
?>
<tr></tr>

<tbody>
</table>
<?php
echo '<br/><br/><a class="btn btn-dark" href="index.php">Revenir à la page précédente !</a>';
?>
</div>
<?php include ("../pages/footer.php"); ?>