<?php
session_start();
include_once("config.php");
mysqli_connect("localhost", "root", "", "gestion");
/*****Verification du mot de passe ****/
if(isset($_POST['mdp'])){
if($_POST['mdp']!="" and $_POST['pseudo']!=""){
	$mdp=$_POST['mdp'];
	$pseudo=$_POST['pseudo'];
	$nb=mysqli_fetch_array(mysqli_query($conn,"select count(*) as nb,type,Num from login where pseudo='$pseudo' and passe='$mdp'"));
	if($nb['nb']==1){
		if($nb['type']=="etudiant")
			$_SESSION['etudiant']=$nb['Num'];
		else if($nb['type']=="prof")
			$_SESSION['prof']=$nb['Num'];
		else if($nb['type']=="admin")
			$_SESSION['admin']=$nb['Num'];
	}
	else{
	?>	<SCRIPT LANGUAGE="Javascript">alert("Login ou mot de passe incorrect");</SCRIPT> 	<?php
	}
	}
	else{
	?> 	<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");	</SCRIPT> 	<?php
	}
}
else if(isset($_GET['sortir'])){
session_destroy();
header("location:index.php");
}
function colspan($min,$max){
if(isset($_SESSION['admin']))
	return $max;
else
	return $min;
}
function rond(){
if(isset($_SESSION['admin']))
	return 'rounded-q1';	
else
	return 'rounded-company';
}
function Edition(){
 if(isset($_SESSION['admin']))
 return '<th colspan="2" class="rounded-company">EDITION</th>';
 else
 return '';
}
function Edition2(){//si on veut affcher edtition pour le prof aussi
 if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
 return '<th colspan="2" class="rounded-company">EDITION</th>';
 else
 return '';
}
function rond2(){//si on veut affcher edtition pour le prof aussi
if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
	return 'rounded-q1';	
else
	return 'rounded-company';
}
Function colspan2($min,$max){//si on veut affcher edtition pour le prof aussi
if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
	return $max;
else
	return $min;
}
Function choixpardefault2($var1,$var2)//pour selection l'element à modifier par defautl
{
if($var1==$var2)
return 'selected="selected"';
else
return "";
}
require_once("config.php");
$data=mysqli_query($conn,"select distinct nom from classe");
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen" type="text/css" title="Essai" href="style.css" />
<link rel="stylesheet" media="screen" type="text/css" title="Essai" href="table.css" />
<body>
<div class="ombre"></div>
<div class="entete"><center></center></div>

<div class="menu">
&nbsp;&nbsp;&nbsp;<font color="white">Menu</font><br/><br/>
<div id="monmenu" >
		<ul class="niveau1">
			<li><a href="1" class="fly">Etudiants </a>
				<ul class="niveau2" style="top : 4px;">
					<li><a href="listeEtudiant.php?list=true">Consulter la liste</a>
						<ul class="niveau3">
						<?php $retour=mysqli_query($conn,"select distinct nom from classe");
							while($a=mysqli_fetch_array($retour)){
							echo '<li><a href="listeEtudiant.php?nomcl='.$a['nom'].'">'.$a['nom'].'</a></li>';				
							}
							?>
						</ul>
					</li>
					<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){/*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/
					echo '<li><a href="afficher_note.php">Consulter les notes</a>
							<ul class="niveau3">';
								while($nomcl=mysqli_fetch_array($data)){
								echo '<li><a href="afficher_note.php?nomcl='.$nomcl['nom'].'">'.$nomcl['nom'].'</a></li>';
								}
						echo '</ul>
						</li>';
				if(!isset($_SESSION['prof'])){ echo '<li><a href="Ajout_etudiant.php">Ajouter un etudiant</a></li>';
					} }
				if(isset($_SESSION['etudiant'])){ echo '<li><a href="note_etudiant.php">Consulter les notes</a></li>'; } ?>
					<li><a href="chercher_eleve.php?cherche_eleve=true">Chercher un étudiant</a></li>
				</ul>
			</li>
			<li><a href="#">Enseignants</a>
				<ul class="niveau2" >
					<li><a href="afficher_prof.php">Liste des enseignants</a></li>
					<?php if((isset($_SESSION['admin'])) or (isset($_SESSION['prof']))){
					if(!isset($_SESSION['prof'])){echo '<li><a href="ajout_prof.php">Ajouter un enseignant</a></li>';}
					}
					?>	
					<li><a href="chercher_prof.php?cherche_prof=true">Chercher un enseignant</a></li>
				</ul>
			</li>
			<?php
			$data=mysqli_query($conn,"select distinct nom from classe");
			echo '<li><a href="#">Classes</a>
					<ul class="niveau2" >
						<li><a href="affiche_classe.php">Voir les classes</a></li>';
						if(!isset($_SESSION['admin']))
						echo '</ul>';
						 else{
						echo '<li><a href="ajout_classe.php">Ajouter une classe</a></li>
					</ul>
				</li>';	}?>
			<li><a href="#">Stages</a>
					<ul class="niveau2" >
						<li><a href="afficher_stage.php">Voir les stages</a></li>
					<?php if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_stage.php">Ajouter un stage</a></li>'; } ?>
						<li><a href="chercher_stage.php?cherche_stage=true">Chercher un stage</a></li>
					</ul>
			</li>			
			<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ echo '<li><a href="#">Conseil</a>
					<ul class="niveau2" >';
					echo '<li><a href="affiche_conseil.php">Voir les conseils</a></li>'; 
					if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_conseil.php">Ajouter un conseil</a></li>'; } 
				echo '</ul>
				</li>'; } ?>
			<li><a href="#">Matière </a>
				<ul class="niveau2">
					<li><li><a href="#">Voir les matières</a>
						<ul class="niveau3">
							<?php	while($nomcl=mysqli_fetch_array($data)){
								echo '<li><a href="afficher_matiere.php?nomcl='.$nomcl['nom'].'">'.$nomcl['nom'].'</a></li>';
								}
					echo '</ul>
					</li>';
				if(isset($_SESSION['admin'])){ echo '<li><li><a href="ajout_matiere.php">Ajouter une matière</a></li>'; }
				echo '</ul>
			</li>';
			if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ echo'<li><a href="#">Bulletins</a>
				<ul class="niveau2">';
					//if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_bulettin.php">Ajouter une note final</a></li>'; }
				 echo '<li><a href="afficher_bulettin.php">note final d\'un etudiant</a></li>'; 
			echo'</ul>
			</li>';}
			echo '<li><a href="#">Diplômes</a>
				<ul class="niveau2">
					<li><a href="type_diplome.php">Types de diplômes</a></li>';
					 if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
					echo '<li><a href="diplome_obt.php">Diplômes obtenus</a></li>	';
					if(isset($_SESSION['admin']))
					echo '<li><a href="ajout_diplome.php?ajout_type">Ajouter un nouveau type</a></li>
					<li><a href="ajout_diplome.php?ajout_diplome">Ajouter une obtention </a>	</li>'; ?>
				</ul>
			</li>
		<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
			echo '<li><a href="#">Evalutation</a>
						<ul class="niveau2">
							<li><a href="ajout_eval.php">Ajouter une evaluation</a></li>
							<li><a href="afficher_evaluation.php">Voir les evalutations</a></li>
						</ul>
					</li>	
			<li><a href="ajout_devoir.php">Devoirs</a>
				<ul class="niveau2">
				<li><a href="ajout_devoir.php">Ajouter un devoir</a></li>
				<li><a href="afficher_devoir.php">Voir les devoirs</a></li>
				</ul>
			</li>';
		?>	
			<li><a href="#">Enseignement </a>
				<ul class="niveau2" >
					<li><a href="afficher_enseign.php">Voir les enseignement</a></li>
					<?php if(isset($_SESSION['admin'])){/*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/
					echo '<li><a href="ajout_enseignement.php">Ajouter un enseignement</a></li>';
					} ?>
				</ul>
			</li>		
		</ul>
	</div>
		<?php //} ?>
		</div>
<div class="connexion2">
&nbsp;&nbsp;&nbsp;<font color="white">Connexion</font><br/><br/>
<?php if(!(isset($_SESSION['admin'])) and !isset($_SESSION['prof']) and !isset($_SESSION['etudiant'])){
?>
<form action="index.php" method="post">
<FIELDSET>
<LEGEND align=top>Authentification<LEGEND>  <pre>
Pseudo :<br/><input type="text" name="pseudo" size="15">
Mot de passe :<br/><input type="password" name="mdp" size="15"><br/><br/><input type="submit" value="envoyer"><br/>
</pre></fieldset>
</form>
<?php
}
else
echo '<br/><br/><br/><li><a href="index.php?sortir=1">Deconexion</a></li>';
?>
</div>
<div class="pied"><br/><center>&reg; 2010 Ecole supérieure de technologie de Berrechid. Gestion de scolarité</center></div>