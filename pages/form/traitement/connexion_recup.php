<?php 

session_start();
include_once "../../controller/config.php";
include_once "../../controller/function.php";

if ($_SERVER["PHP_SELF"] == "/gestion00/pages/form/traitement/connexion_recup.php"){
    if (isset($_POST["connexion"])) {
        $type = $_POST["type"];
        $password = $_POST["mdp"];
        $pseudo = $_POST["pseudo"];

        $type_err = $pseudo_err = $password_err = "";
        if ($type == "Choisir.."){
            $type = "";
        }

        if (empty($type) || empty($password) || empty($pseudo)) {
            if (empty($type)) {
                $_SESSION["type_err_conn"] = "Veuillez choisir un type";
            } 
            if (empty($password)) {
                $_SESSION["password_err_conn"] = "Veuillez entrer un mot de passe";
            } 
            if (empty($pseudo)){
                $_SESSION["pseudo_err_conn"] = "Veuillez entrer un pseudo";
            }
            
            header("location: /gestion00/pages/form/connexion.php");
        } else {
            $req = "SELECT id, num FROM login WHERE pseudo = ? && passe = ?";
            $stmt = mysqli_prepare($conn, $req);
            mysqli_stmt_bind_param($stmt, "ss", $pseudo, $password);
            mysqli_stmt_bind_result($stmt, $id, $num);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_fetch($stmt);
            print_r($id);
            
            if ($id >= 1) {
                echo "oui 1";
                $_SESSION["type_conn"] = $_POST["type"];
                $connexion = $_SESSION["connexion_yes"] = "YES";
                echo $_SESSION["type_conn"];

                    if($_SESSION['type_conn']=="etudiant"){
                        $_SESSION['etudiant']=$num;
                    }
                    else if($_SESSION['type_conn']=="prof"){
                        $_SESSION['prof']=$num;
                    }
                    else if($_SESSION['type_conn']=="admin"){
                        $_SESSION['admin']=$num;
                    }

                    echo $id;
                

                header("location: ../../home.php");

            } else {
                $_SESSION["type_err_conn"] = "Vérifier vos entrées, il y a une erreur";
                header("location: /gestion00/pages/form/connexion.php");
            }
        }
    }
}


?>