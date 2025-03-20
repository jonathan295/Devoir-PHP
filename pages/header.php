<?php
	session_start();
	include_once "controller/config.php";
	include_once "controller/function.php";
	$req = "SELECT DISTINCT nom FROM classe";
	$datas = mysqli_fetch_all(mysqli_query($conn, $req), MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/modals/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/gestion/style/all.css">
	<link rel="stylesheet" href="/gestion/style/color.css">
	<title>Document</title>
</head>
<body>
	<style>
		.dropdown:hover > .dropdown-menu, .dropend:hover > .dropdown-menu{
			display: block;
			border-radius: 0 !important;
		}
		.dropend:hover > .dropdown-menu{
			position: absolute;
			top: -22%;
			right: -99%;
			border-radius: 0 !important;
		}

		.position_titre{
			width: 50%;
			height: 50%;
			object-fit: cover;
		}

		@media screen and (max-width: 768px){
			.bg_entete{
				display: none;
			}
		}
		@media screen and (max-width: 1240px){
			*{
				text-align: center;
			}
			.dropdown:hover > .dropdown-menu, .dropend:hover > .dropdown-menu{
				position: inherit;
				display: block;
				border-radius: 0 !important;
				opacity: 1;
			}
			.dropend:hover > .dropdown-menu{
				position: inherit;
				top: 100%;
				right: 0;
				border-radius: 0 !important;
				opacity: 1;
			}
		}

		input{
			color: white;
			border-radius: 50px;
			border: 2px solid white;
			background: #04404491;
			backdrop-filter: blur(10px);
		}
		textarea{
			color: black;
			border: 2px solid white;
			background: #80808073;
		}

		.calendar{
			color: black;
			background-color: grey;
		}

		.flex-column{
			border: none;
			white-space: collapse;
			padding: 2%;
			/* background: #1e1e1e; */
			box-shadow: 0 0 20px 5px rgba(0, 0, 0, 0.295);
		}

		.object-fit-cover{
			object-fit: cover !important;
		}

	</style>

	<div class="container-fluid mb-1 bg_entete" style="height: 400px; max-height: 400px;">
		<img src="/gestion/image/bg_entete.jpg" alt="" class="object-fit-cover w-100 h-100">
	</div>
	<div class="container-fluid mb-4 sticky-top" id="navContainer">
		<nav class="navbar navbar-expand-lg justify-content-between">
			<div class="container-fluid">
					<a class="navbar-brand w-25" style="max-width: 100px;" href="/gestion/image/logo_insi.png">
						<img src="/gestion/image/logo-insi.png" alt="" class="object-fit-contain w-100 h-100">
					</a>
					<button class="border-white navbar-toggler p-2" style="width: 100px; max-width: 100px;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<img src="/gestion/image/menu.png" alt="" class="object-fit-contain w-25 h-25">
					</button>
					</button>
					<div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item dropdown">
        				        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Etudiants</a>
								<ul class="dropdown-menu shadow">
									<li class="nav-item dropend">
										<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Consulter la liste</a>
										<ul class="dropdown-menu shadow">
										<?php 
											$req = "SELECT DISTINCT nom FROM classe";
											$results = mysqli_fetch_all(mysqli_query($conn, $req), MYSQLI_ASSOC);
											foreach ($results as $result){
											    echo '<li><a class="nav-link dropdown-item text-center" href="/gestion/gestion/listeEtudiant.php?nomcl='.$result['nom'].'">'.$result['nom'].'</a></li>';				
											}
										?>
										</ul>
									</li>
								<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): /*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/?>
								    <li class="nav-item dropend">
										<a class="nav-link dropdown-toggle text-white" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="/gestion/gestion/afficher_note.php">Consulter les notes</a>
										<ul class="dropdown-menu shadow">
										<?php foreach($datas as $data): ?>	
											<li class="nav-item">
												<a class="nav-link dropdown-item text-center" href="/gestion/gestion/afficher_note.php?nomcl=<?php echo $data['nom']; ?>"><?php echo $data["nom"]; ?></a>
											</li>
										<?php endforeach; ?>
										</ul>
									</li>
								<?php endif; ?>
								
								<?php if(isset($_SESSION['prof']) or isset($_SESSION["admin"])): ?>
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion/gestion/Ajout_etudiant.php">Ajouter un etudiant</a></li>
								<?php endif; ?>
								<?php if(isset($_SESSION['etudiant'])): ?>
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion/gestion/note_etudiant.php">Consulter les notes</a></li>
								<?php endif; ?>
								<?php if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])): ?>
									<li class="nav-item"><a class="nav-link dropdown-item" href="/gestion/gestion/chercher_eleve.php?cherche_eleve=true">Chercher un étudiant</a></li>
								<?php endif; ?>
								</ul>
							</li>
							<li class="nav-item dropdown">
        				        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Enseignants</a>
								<ul class="dropdown-menu shadow">
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/afficher_prof.php">Liste des enseignants</a></li>
								<?php if((isset($_SESSION['admin'])) or (isset($_SESSION['prof']))): ?>
								    <?php if(isset($_SESSION['admin'])): ?>
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_prof.php">Ajouter un enseignant</a></li>
									<?php endif; ?>	
									<?php if(isset($_SESSION['admin']) && isset($_SESSION["prof"])): ?>
									<li class="nav-item">
        				                <a class="nav-link dropdown-item text-center" href="/gestion/gestion/chercher_prof.php?cherche_prof=true">Chercher un enseignant</a>
        				            </li>
									<?php endif; ?>	
								<?php endif; ?>
								</ul>
							</li>
        				    <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Classes</a>
								<ul class="dropdown-menu shadow">
									<li class="nav-item">
										<a class="nav-link dropdown-item text-center" style="" href="/gestion/gestion/affiche_classe.php">Voir les classes</a>
									</li>
        				<?php if(!isset($_SESSION['admin'])): ?>
        				        </ul>
							<?php else: ?>
        					    	<li class="nav-item">
										<a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_classe.php">Ajouter une classe</a>
									</li>
								</ul>
							</li>
						<?php endif; ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Stages</a>
								<ul class="dropdown-menu shadow" >
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/afficher_stage.php">Voir les stages</a></li>
								<?php if(!isset($_SESSION['admin'])): ?>
									<?php else: ?>
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_stage.php">Ajouter un stage</a></li>
								<?php endif; ?>
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/chercher_stage.php?cherche_stage=true">Chercher un stage</a></li>
								</ul>
							</li>			
						<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Conseil</a>
								<ul class="dropdown-menu shadow">
									<li class="nav-item">
										<a class="nav-link dropdown-item text-center" href="/gestion/gestion/affiche_conseil.php">Voir les conseils</a>
									</li>
								<?php if(isset($_SESSION['admin'])): ?> 
									<li class="nav-item">
										<a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_conseil.php">Ajouter un conseil</a>
									</li> 
								<?php endif; ?>
								</ul>
							</li>
						<?php endif; ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Matière</a>
								<ul class="dropdown-menu shadow">
									<li class="nav-item">
        				                <li class="nav-item dropend">
											<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Voir les matières</a>
											<ul class="dropdown-menu shadow">
												<?php $results = showItemNav($conn, "SELECT DISTINCT nom FROM classe", $result); ?>
												<?php foreach($results as $result): ?>
												<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/afficher_matiere.php?nomcl=<?php echo $result['nom'] ?>"><?php echo $result["nom"]; ?></a></li>
												<?php endforeach; ?>
											</ul> 
										</li>
										<?php if(isset($_SESSION['admin'])): ?>
										<li class="nav-item">
											<li class="nav-item">
												<a class="nav-link dropdown-item" href="/gestion/gestion/ajout_matiere.php">Ajouter une matière</a>
											</li>
										</li>
										<?php endif; ?>
									</li>
								<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): ?> 
									<li class="nav-item dropend">
										<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bulletins</a>
										<ul class="dropdown-menu shadow">
										<?php if(isset($_SESSION['admin'])): ?>
											<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_bulettin.php">Ajouter une note final</a></li>
										<?php endif; ?>
											<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/afficher_bulettin.php">note final d'un etudiant</a></li>
										</ul>
									</li>
								<?php endif; ?>
								</ul>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Diplômes</a>
								<ul class="dropdown-menu shadow">
									<li class="nav-item">
										<a class="nav-link dropdown-item text-center" href="/gestion/gestion/type_diplome.php">Types de diplômes</a>
									</li>
								<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): ?>
									<li class="nav-item">
										<a class="nav-link dropdown-item text-center" href="/gestion/gestion/diplome_obt.php">Diplômes obtenus</a>
									</li>
									<?php if(isset($_SESSION['admin'])): ?>
									<li class="nav-item">
										<a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_diplome.php?ajout_type">Ajouter un nouveau type</a>
									</li>
									<li class="nav-item">
										<a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_diplome.php?ajout_diplome">Ajouter une obtention</a>	
									</li>
									<?php endif; ?>
								<?php endif; ?>
								</ul>
								</li>
        				    </li>
						<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Evalutation</a>
								<ul class="dropdown-menu shadow">
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_eval.php?ajout_eval">Ajouter une evaluation</a></li>
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/afficher_evaluation.php">Voir les evalutations</a></li>
								</ul>
							</li>	
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle text-white" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="/gestion/gestion/ajout_devoir.php">Devoirs</a>
								<ul class="dropdown-menu shadow">
								<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_devoir.php">Ajouter un devoir</a></li>
								<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/afficher_devoir.php">Voir les devoirs</a></li>
								</ul>
							</li>
						<?php endif; ?>	
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Enseignement </a>
								<ul class="dropdown-menu shadow" style="right: 0;">
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/afficher_enseign.php">Voir les enseignement</a></li>
								<?php if(isset($_SESSION['admin'])): /*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/?>
									<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/gestion/ajout_enseignement.php">Ajouter un enseignement</a></li>
								<?php endif; ?>
								</ul>
							</li>				
        				    <li class="nav-item dropdown">
								<div class="nav-item d-flex align-items-center nav-item">
									<div class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width:50px;">
										<img src="/gestion/image/user_icone.png" alt="user" style="object-fit: contain; width: 100%; height: 100%;">
									</div>
									<a href="#" class="text-uppercase text-white nav-link" style="margin:0;"><?php if (isset($_SESSION["type_conn"])) {echo $_SESSION["type_conn"];} ?></a>
								</div>
								<ul class="dropdown-menu shadow" style="right: 0;">
									<?php if (isset($_SESSION["type_conn"])): ?>
										<!-- <li class="nav-item"><a class="nav-link" href="">Profil</a></li> -->
										<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/pages/form/deconnexion.php">Deconnexion</a></li>
									<?php else : ?>
										<li class="nav-item">
											<a class="nav-link dropdown-item text-center" href="
												<?php 
													if ($_SERVER["PHP_SELF"]=="/gestion/pages/form/connexion.php") 
														{echo "#";} 
													else {echo "/gestion/pages/form/connexion.php";} 
												?>
											">Connexion</a>
										</li>
										<li class="nav-item"><a class="nav-link dropdown-item text-center" href="/gestion/pages/form/inscription.php">Inscription</a></li>
									<?php endif; ?>
								</ul>
							</li>
        				</ul>
					</div>
				<div>
			</div>
		</nav>
	</div>


