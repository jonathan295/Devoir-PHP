<?php
//session_start();
/*****Verification du mot de passe ****/
if(isset($_POST['mdp'])){
	if($_POST['mdp']!="" and $_POST['pseudo']!=""){
		$mdp=$_POST['mdp'];
		$pseudo=$_POST['pseudo'];
		$nb=req_mysql($conn,"SELECT count(*) AS nb,type,Num FROM login WHERE pseudo=? AND passe=?", [$mdp, $pseudo], PDO::FETCH_ASSOC);
		if($nb['nb']==1){
			if($nb['type']=="etudiant")
				$_SESSION['etudiant']=$nb['Num'];
			else if($nb['type']=="prof")
				$_SESSION['prof']=$nb['Num'];
			else if($nb['type']=="admin")
				$_SESSION['admin']=$nb['Num'];
		}
		else{
?>	
        <SCRIPT LANGUAGE="Javascript">alert("Login ou mot de passe incorrect");</SCRIPT> 	
<?php
	}
}else{
?> 	
<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");	</SCRIPT> 	
<?php
		}
	}else if(isset($_GET['sortir'])){
		session_destroy();
		header("location:index.php");
	}
	function colspan($min,$max){
		if(isset($_SESSION['admin'])){
			return $max;
		}
		else{
			return $min;
		}
	}
	function rond(){
		if(isset($_SESSION['admin'])){
			return 'rounded-q1';	
		}else{
			return 'rounded-company';
		}
	}
	function Edition(){
		if(isset($_SESSION['admin'])){
			return '<th colspan="2" class="rounded-company">EDITION</th>';
		}
		else{
			return '';
		}
	}
	function Edition2(){//si on veut affcher edtition pour le prof aussi
		if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){
			return '<th colspan="2" class="rounded-company">EDITION</th>';
		}
		else{
			return '';
		}
	}
	function rond2(){//si on veut affcher edtition pour le prof aussi
		if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){
			return 'rounded-q1';	
		}
		else{
			return 'rounded-company';
		}
	}
	Function colspan2($min,$max){//si on veut affcher edtition pour le prof aussi
		if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
			{
				return $max;
			}
		else{
			return $min;
		}
	}
	Function choixpardefault2($var1,$var2)//pour selection l'element � modifier par defautl
		{
			if($var1==$var2){
				return 'selected="selected"';
			}
			else{
				return "";
			}
		}
	require_once("controller/config.php");
	$datas=req_mysql($conn,"SELECT DISTINCT nom FROM classe", [], PDO::FETCH_ASSOC);
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<title>Document</title>
	<style>
		.dropdown:hover > .dropdown-menu, .dropend:hover > .dropdown-menu{
			display: block;
			margin-top: 1%;
		}
		.dropend:hover > .dropdown-menu{
			position: absolute;
			top: 0;
			left: 100%;
			margin-top: 1%;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<nav class="navbar navbar-expand-lg bg-body-tertiary">
			<div class="container-fluid">
					<a class="navbar-brand" href="#">Navbar</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
						<ul class="navbar-nav">
							<li class="nav-item dropdown">
        				        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Etudiants</a>
								<ul class="dropdown-menu">
									<li class="nav-item dropend">
										<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Consulter la liste</a>
										<ul class="dropdown-menu">
										<?php 
        				                    $results=req_mysql($conn,"SELECT DISTINCT nom FROM classe",[], PDO::FETCH_ASSOC);
											foreach ($results as $result){
											    echo '<li><a class="nav-link dropdown-item" href="listeEtudiant.php?nomcl='.$result['nom'].'">'.$result['nom'].'</a></li>';				
											}
										?>
										</ul>
									</li>
									<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){/*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/
									    echo '<li class="nav-item dropend"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="afficher_note.php">Consulter les notes</a>
											<ul class="dropdown-menu">';
												foreach($datas as $data){
												echo '<li class="nav-item"><a class="nav-link dropdown-item" href="afficher_note.php?nomcl='.$data['nom'].'">'.$data['nom'].'</a></li>';
												}
										echo '</ul></li>';
								if(!isset($_SESSION['prof'])){ echo '<li class="nav-item"><a class="nav-link" href="Ajout_etudiant.php">Ajouter un etudiant</a></li>';
									} }
								if(isset($_SESSION['etudiant'])){ echo '<li class="nav-item"><a class="nav-link" href="note_etudiant.php">Consulter les notes</a></li>'; } ?>
									<li class="nav-item"><a class="nav-link" href="chercher_eleve.php?cherche_eleve=true">Chercher un étudiant</a></li>
								</ul>
							</li>
							<li class="nav-item dropdown">
        				        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Enseignants</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link dropdown-item" href="afficher_prof.php">Liste des enseignants</a></li>
									<?php 
        				                if((isset($_SESSION['admin'])) or (isset($_SESSION['prof']))){
									        if(!isset($_SESSION['prof'])){echo '<li class="nav-item"><a class="nav-link dropdown-item" href="ajout_prof.php">Ajouter un enseignant</a></li>';}
									    }
									?>	
									<li class="nav-item">
        				                <a class="nav-link dropdown-item" href="chercher_prof.php?cherche_prof=true">Chercher un enseignant</a>
        				            </li>
								</ul>
							</li>
							<?php
        				        $datas=req_mysql($conn,"SELECT DISTINCT nom FROM classe", [], PDO::FETCH_ASSOC);
        				        echo '<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Classes</a>
									<ul class="dropdown-menu">
									<li class="nav-item">
										<a class="nav-link dropdown-item" href="affiche_classe.php">Voir les classes</a>
									</li>';
        				        if(!isset($_SESSION['admin'])){
        				            echo '</ul>';
        				        }else{
        				            echo '<li class="nav-item"><a class="nav-link dropdown-item" href="ajout_classe.php">Ajouter une classe</a></li></ul></li>';	
        				        }
        				    ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Stages</a>
								<ul class="dropdown-menu" >
									<li class="nav-item"><a class="nav-link dropdown-item" href="afficher_stage.php">Voir les stages</a></li>
								<?php if(isset($_SESSION['admin'])){ echo '<li class="nav-item"><a class="nav-link dropdown-item" href="ajout_stage.php">Ajouter un stage</a></li>'; } ?>
									<li class="nav-item"><a class="nav-link dropdown-item" href="chercher_stage.php?cherche_stage=true">Chercher un stage</a></li>
								</ul>
							</li>			
							<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ 
								echo '<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Conseil</a>
										<ul class="dropdown-menu">
											<li class="nav-item"><a class="nav-link dropdown-item" href="affiche_conseil.php">Voir les conseils</a></li>'; 
									if(isset($_SESSION['admin'])){ 
										echo '<li class="nav-item"><a class="nav-link dropdown-item" href="ajout_conseil.php">Ajouter un conseil</a></li>'; 
									} 
								echo '</ul>
									</li>'; } ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Matière</a>
								<ul class="dropdown-menu">
									<li class="nav-item">
        				                <li class="nav-item dropend">
											<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Voir les matières</a>
											<ul class="dropdown-menu">
												<?php	
													foreach($datas as $data){
														echo '<li class="nav-item"><a class="nav-link dropdown-item" href="afficher_matiere.php?nomcl='.$data['nom'].'">'.$data['nom'].'</a></li>';
														}
													echo '</ul> </li>';
													if(isset($_SESSION['admin'])){ 
														echo '<li class="nav-item"><li class="nav-item"><a class="nav-link" href="ajout_matiere.php">Ajouter une matière</a></li>'; }
														echo '</ul></li>';
														if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ 
															echo'<li class="nav-item dropdown">
																	<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Bulletins</a>
																	<ul class="dropdown-menu">';
														//if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_bulettin.php">Ajouter une note final</a></li>'; }
															echo '<li class="nav-item"><a class="nav-link dropdown-item" href="afficher_bulettin.php">note final d\'un etudiant</a></li>'; 
															echo'</ul></li>';}
															echo '<li class="nav-item dropdown">
																	<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Diplômes</a>
																	<ul class="dropdown-menu">
																		<li class="nav-item"><a class="nav-link dropdown-item" href="type_diplome.php">Types de diplômes</a></li>';
															if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
																echo '<li class="nav-item"><a class="nav-link dropdown-item" href="diplome_obt.php">Diplômes obtenus</a></li>	';
															if(isset($_SESSION['admin']))
																echo '<li class="nav-item"><a class="nav-link dropdown-item" href="ajout_diplome.php?ajout_type">Ajouter un nouveau type</a></li>
																<li class="nav-item"><a class="nav-link dropdown-item" href="ajout_diplome.php?ajout_diplome">Ajouter une obtention </a>	</li>'; 
												?>
											</ul>
										</li>
        				            </li>
						<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
							echo '<li class="nav-item dropdown">
        				            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Evalutation</a>
									<ul class="dropdown-menu">
										<li class="nav-item"><a class="nav-link dropdown-item" href="ajout_eval.php">Ajouter une evaluation</a></li>
										<li class="nav-item"><a class="nav-link dropdown-item" href="afficher_evaluation.php">Voir les evalutations</a></li>
						            </ul>
								</li>	
        				        <li class="nav-item dropdown">
        				            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="ajout_devoir.php">Devoirs</a>
        				            <ul class="dropdown-menu">
        				            <li class="nav-item"><a class="nav-link dropdown-item" href="ajout_devoir.php">Ajouter un devoir</a></li>
        				            <li class="nav-item"><a class="nav-link dropdown-item" href="afficher_devoir.php">Voir les devoirs</a></li>
        				            </ul>
        				        </li>';
						?>	
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Enseignement </a>
								<ul class="dropdown-menu" >
									<li class="nav-item"><a class="nav-link dropdown-item" href="afficher_enseign.php">Voir les enseignement</a></li>
									<?php if(isset($_SESSION['admin'])){/*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/
									echo '<li class="nav-item"><a class="nav-link dropdown-item" href="ajout_enseignement.php">Ajouter un enseignement</a></li>';
									} ?>
								</ul>
							</li>				
        				    <li class="nav-item dropdown">
								<div class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width:50px;">
									<img src="/newgestion/pages/user_icone.png" alt="user" style="object-fit: contain; width: 100%; height: 100%;">
								</div>
								<ul class="dropdown-menu" style="right: 0;">
									<li class="nav-item">
										<a class="nav-link" href="
										<?php 
											if ($_SERVER["PHP_SELF"]=="/newgestion/pages/connexion.php") 
												{echo "#";} 
											else {echo "/newgestion/pages/connexion.php";} 
										?>
									 ">Connexion</a>
									</li>
									<li class="nav-item"><a class="nav-link" href="">Déconnexion</a></li>
								</ul>
							</li>
        				</ul>
					</div>
			</div>
		</nav>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
