<?php
//session_start();
/*****Verification du mot de passe ****/
include_once "controlleur/config.php";
include_once "controlleur/function.php";
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
    
    
    
    
    <div id="">
		<ul class="">
			<li>
                <a href="" class="">Etudiants</a>
				<ul class="" style="">
					<li><a href="">Consulter la liste</a>
						<ul class="">
						<?php 
                            $results=req_mysql($conn,"SELECT DISTINCT nom FROM classe",[], PDO::FETCH_ASSOC);
							foreach ($results as $result){
							    echo '<li><a href="listeEtudiant.php?nomcl='.$result['nom'].'">'.$result['nom'].'</a></li>';				
							}
						?>
						</ul>
					</li>
					<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){/*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/
					    echo '<li><a href="afficher_note.php">Consulter les notes</a>
							<ul class="">';
								foreach($datas as $data){
								echo '<li><a href="afficher_note.php?nomcl='.$data['nom'].'">'.$data['nom'].'</a></li>';
								}
						echo '</ul></li>';
				if(!isset($_SESSION['prof'])){ echo '<li><a href="Ajout_etudiant.php">Ajouter un etudiant</a></li>';
					} }
				if(isset($_SESSION['etudiant'])){ echo '<li><a href="note_etudiant.php">Consulter les notes</a></li>'; } ?>
					<li><a href="chercher_eleve.php?cherche_eleve=true">Chercher un étudiant</a></li>
				</ul>
			</li>
			<li>
                <a href="#">Enseignants</a>
				<ul class="niveau2" >
					<li><a href="afficher_prof.php">Liste des enseignants</a></li>
					<?php 
                        if((isset($_SESSION['admin'])) or (isset($_SESSION['prof']))){
					        if(!isset($_SESSION['prof'])){echo '<li><a href="ajout_prof.php">Ajouter un enseignant</a></li>';}
					    }
					?>	
					<li>
                        <a href="chercher_prof.php?cherche_prof=true">Chercher un enseignant</a>
                    </li>
				</ul>
			</li>
			<?php
                $datas=req_mysql($conn,"SELECT DISTINCT nom FROM classe", [], PDO::FETCH_ASSOC);
                echo '<li><a href="#">Classes</a><ul class=""><li><a href="affiche_classe.php">Voir les classes</a></li>';
                if(!isset($_SESSION['admin'])){
                    echo '</ul>';
                }else{
                    echo '<li><a href="ajout_classe.php">Ajouter une classe</a></li></ul></li>';	
                }
            ?>
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
				<ul class="">
					<li>
                        <li><a href="#">Voir les matières</a>
						<ul class="">
							<?php	
                                foreach($datas as $data){
                                    echo '<li><a href="afficher_matiere.php?nomcl='.$data['nom'].'">'.$data['nom'].'</a></li>';
                                    }
					            echo '</ul> </li>';
				                if(isset($_SESSION['admin'])){ echo '<li><li><a href="ajout_matiere.php">Ajouter une matière</a></li>'; }
				                    echo '</ul></li>';
			                        if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ 
                                        echo'<li><a href="#">Bulletins</a><ul class="niveau2">';
					                //if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_bulettin.php">Ajouter une note final</a></li>'; }
				                        echo '<li><a href="afficher_bulettin.php">note final d\'un etudiant</a></li>'; 
			                            echo'</ul></li>';}
			                            echo '<li><a href="#">Diplômes</a><ul class="niveau2">
                                                <li><a href="type_diplome.php">Types de diplômes</a></li>';
                                        if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
                                            echo '<li><a href="diplome_obt.php">Diplômes obtenus</a></li>	';
                                        if(isset($_SESSION['admin']))
                                            echo '<li><a href="ajout_diplome.php?ajout_type">Ajouter un nouveau type</a></li>
                                            <li><a href="ajout_diplome.php?ajout_diplome">Ajouter une obtention </a>	</li>'; 
                            ?>
                        </ul>
                    </li>
		<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
			echo '<li>
                    <a href="#">Evalutation</a>
					<ul class="niveau2">
						<li><a href="ajout_eval.php">Ajouter une evaluation</a></li>
						<li><a href="afficher_evaluation.php">Voir les evalutations</a></li>
		            </ul>
				</li>	
                <li>
                    <a href="ajout_devoir.php">Devoirs</a>
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
            <li><a href="controller/connexion.php">USER</a></li>
        </ul>
	</div>
