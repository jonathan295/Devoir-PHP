<?php
	session_start();
	include_once "controller/config.php";
	include_once "controller/function.php";
	// $datas = showItemNav($conn, "SELECT DISTINCT nom FROM classe", $datas); 
	$req = "SELECT DISTINCT nom FROM classe";
	$datas = mysqli_fetch_all(mysqli_query($conn, $req), MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<!-- Option 1: Include in HTML -->
	<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"> -->
	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
	<link href="<?php if ($_SERVER["PHP_SELF"]=="/gestion00/pages/form/connexion.php") {echo "/gestion00/style/styleformulaire.css";} ?>" rel="stylesheet">
	<link rel="stylesheet" href="/gestion00/style/all.css">
	<link rel="stylesheet" href="/gestion00/style/styleheader.css">
	<link rel="stylesheet" href="/gestion00/style/add.css">
	<title>Document</title>
</head>
<body>
	<div class="container-fluid sticky-top">
		<nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
			<div class="container-fluid">
					<a class="navbar-brand" href="#">Navbar</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item dropdown">
        				        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Etudiants</a>
								<ul class="dropdown-menu">
									<li class="nav-item dropend">
										<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Consulter la liste</a>
										<ul class="dropdown-menu">
										<?php 
											$req = "SELECT DISTINCT nom FROM classe";
											$results = mysqli_fetch_all(mysqli_query($conn, $req), MYSQLI_ASSOC);
											foreach ($results as $result){
											    echo '<li><a class="nav-link dropdown-item" href="/gestion00/gestion/listeEtudiant.php?nomcl='.$result['nom'].'">'.$result['nom'].'</a></li>';				
											}
										?>
										</ul>
									</li>
								<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): /*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/?>
								    <li class="nav-item dropend">
										<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="/gestion00/gestion/afficher_note.php">Consulter les notes</a>
										<ul class="dropdown-menu">
										<?php foreach($datas as $data): ?>	
											<li class="nav-item">
												<a class="nav-link dropdown-item" href="/gestion00/gestion/afficher_note.php?nomcl=<?php echo $data['nom']; ?>"><?php echo $data["nom"]; ?></a>
											</li>
										<?php endforeach; ?>
										</ul>
									</li>
								<?php endif; ?>
								
								<?php if(isset($_SESSION['prof']) or isset($_SESSION["admin"])): ?>
									<li class="nav-item"><a class="nav-link" href="/gestion00/gestion/Ajout_etudiant.php">Ajouter un etudiant</a></li>
								<?php endif; ?>
								<?php if(isset($_SESSION['etudiant'])): ?>
									<li class="nav-item"><a class="nav-link" href="/gestion00/gestion/note_etudiant.php">Consulter les notes</a></li>
								<?php endif; ?>
								<?php if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])): ?>
									<li class="nav-item"><a class="nav-link" href="/gestion00/gestion/chercher_eleve.php?cherche_eleve=true">Chercher un étudiant</a></li>
								<?php endif; ?>
								</ul>
							</li>
							<li class="nav-item dropdown">
        				        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Enseignants</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/afficher_prof.php">Liste des enseignants</a></li>
								<?php if((isset($_SESSION['admin'])) or (isset($_SESSION['prof']))): ?>
								    <?php if(isset($_SESSION['admin'])): ?>
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_prof.php">Ajouter un enseignant</a></li>
									<?php endif; ?>	
									<?php if(isset($_SESSION['admin']) && isset($_SESSION["prof"])): ?>
									<li class="nav-item">
        				                <a class="nav-link dropdown-item" href="/gestion00/gestion/chercher_prof.php?cherche_prof=true">Chercher un enseignant</a>
        				            </li>
									<?php endif; ?>	
								<?php endif; ?>
								</ul>
							</li>
        				    <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Classes</a>
								<ul class="dropdown-menu">
									<li class="nav-item">
										<a class="nav-link dropdown-item" style="" href="/gestion00/gestion/affiche_classe.php">Voir les classes</a>
									</li>
        				<?php if(!isset($_SESSION['admin'])): ?>
        				        </ul>
							<?php else: ?>
        					    	<li class="nav-item">
										<a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_classe.php">Ajouter une classe</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Stages</a>
								<ul class="dropdown-menu" >
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/afficher_stage.php">Voir les stages</a></li>
								<?php if(!isset($_SESSION['admin'])): ?>
									<?php else: ?>
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_stage.php">Ajouter un stage</a></li>
								<?php endif; ?>
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/chercher_stage.php?cherche_stage=true">Chercher un stage</a></li>
								</ul>
							</li>			
						<?php if(!isset($_SESSION['admin']) or !isset($_SESSION['prof'])): ?>
							<?php else: ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Conseil</a>
								<ul class="dropdown-menu">
									<li class="nav-item">
										<a class="nav-link dropdown-item" href="/gestion00/gestion/affiche_conseil.php">Voir les conseils</a>
									</li>
								<?php if(isset($_SESSION['admin'])): ?> 
									<li class="nav-item">
										<a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_conseil.php">Ajouter un conseil</a>
									</li> 
								<?php endif; ?>
								</ul>
							</li>
						<?php endif; ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Matière</a>
								<ul class="dropdown-menu">
									<li class="nav-item">
        				                <li class="nav-item dropend">
											<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Voir les matières</a>
											<ul class="dropdown-menu">
												<?php $results = showItemNav($conn, "SELECT DISTINCT nom FROM classe", $result); ?>
												<?php foreach($results as $result): ?>
												<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/afficher_matiere.php?nomcl=<?php echo $result['nom'] ?>"><?php echo $result["nom"]; ?></a></li>
												<?php endforeach; ?>
											</ul> 
										</li>
										<?php if(isset($_SESSION['admin'])): ?>
										<li class="nav-item">
											<li class="nav-item">
												<a class="nav-link" href="/gestion00/gestion/ajout_matiere.php">Ajouter une matière</a>
											</li>
										</li>
										<?php endif; ?>
									</li>
								<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): ?> 
									<li class="nav-item dropend">
										<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bulletins</a>
										<ul class="dropdown-menu">
										<?php if(isset($_SESSION['admin'])): ?>
											<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_bulettin.php">Ajouter une note final</a></li>
										<?php endif; ?>
											<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/afficher_bulettin.php">note final d'un etudiant</a></li>
										</ul>
									</li>
								<?php endif; ?>
								</ul>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Diplômes</a>
								<ul class="dropdown-menu">
									<li class="nav-item">
										<a class="nav-link dropdown-item" href="/gestion00/gestion/type_diplome.php">Types de diplômes</a>
									</li>
								<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): ?>
									<li class="nav-item">
										<a class="nav-link dropdown-item" href="/gestion00/gestion/diplome_obt.php">Diplômes obtenus</a>
									</li>
									<?php if(isset($_SESSION['admin'])): ?>
									<li class="nav-item">
										<a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_diplome.php?ajout_type">Ajouter un nouveau type</a>
									</li>
									<li class="nav-item">
										<a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_diplome.php?ajout_diplome">Ajouter une obtention</a>	
									</li>
									<?php endif; ?>
								<?php endif; ?>
								</ul>
								</li>
        				    </li>
						<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Evalutation</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_eval.php">Ajouter une evaluation</a></li>
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/afficher_evaluation.php">Voir les evalutations</a></li>
								</ul>
							</li>	
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="/gestion00/gestion/ajout_devoir.php">Devoirs</a>
								<ul class="dropdown-menu">
								<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_devoir.php">Ajouter un devoir</a></li>
								<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/afficher_devoir.php">Voir les devoirs</a></li>
								</ul>
							</li>
						<?php endif; ?>	
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Enseignement </a>
								<ul class="dropdown-menu" style="right: 0;">
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/afficher_enseign.php">Voir les enseignement</a></li>
								<?php if(isset($_SESSION['admin'])): /*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/?>
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion00/gestion/ajout_enseignement.php">Ajouter un enseignement</a></li>
								<?php endif; ?>
								</ul>
							</li>				
        				    <li class="nav-item dropdown">
								<div class="nav-item d-flex align-items-center">
									<div class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width:50px;">
										<img src="/gestion00/image/user_icone.png" alt="user" style="object-fit: contain; width: 100%; height: 100%;">
									</div>
									<p class="text-uppercase" style="margin:0;"><?php if (isset($_SESSION["type_conn"])) {echo $_SESSION["type_conn"];} ?></p>
								</div>
								<ul class="dropdown-menu" style="right: 0;">
									<?php if (isset($_SESSION["type_conn"])): ?>
										<!-- <li class="nav-item"><a class="nav-link" href="">Profil</a></li> -->
										<li class="nav-item"><a class="nav-link" href="/gestion00/pages/form/deconnexion.php">Deconnexion</a></li>
									<?php else : ?>
										<li class="nav-item">
											<a class="nav-link" href="
												<?php 
													if ($_SERVER["PHP_SELF"]=="/gestion00/pages/form/connexion.php") 
														{echo "#";} 
													else {echo "/gestion00/pages/form/connexion.php";} 
												?>
											">Connexion</a>
										</li>
										<li class="nav-item"><a class="nav-link" href="/gestion00/pages/form/inscription.php">Inscription</a></li>
									<?php endif; ?>
								</ul>
							</li>
        				</ul>
					</div>
			</div>
		</nav>
	</div>


