<?php
    session_start();
    // echo "<pre>";
    // printf($_SERVER["PHP_SELF"]);
    // echo "</pre>";
    include_once "../../controller/config.php";
    include_once "../../controller/function.php";


    if ($_SERVER["PHP_SELF"] == "/gestion00/pages/form/traitement/inscription_recup.php") {
        if (isset($_POST["inscription"])){
            $nom = htmlspecialchars(trim($_POST["nom"]));
            $prenom = htmlspecialchars(trim($_POST["prenom"]));
            $email = htmlspecialchars(trim($_POST["email"]));
            $password = htmlspecialchars(trim($_POST["password"]));
            $tel = htmlspecialchars(trim($_POST["tel"]));
            $adresse = htmlspecialchars(trim($_POST["adresse"]));
            $type = htmlspecialchars(trim($_POST["type"]));
            $date_naissance = htmlspecialchars(trim($_POST["date_naissance"]));

            // echo $nom . " " . $prenom . " " . $email . " " . $password . " " . $tel . " " . " ". $adresse . " " . $type . " " . $date_naissance; 

            $nom_err = $prenom_err = $email_err = $password_err = $tel_err = $adresse_err = $type_err = $date_naissance_err = "";

            // Validate name
            if (empty($nom)) {
                $nom_err = "Veuillez entrer un nom.";
            }

            // Validate prenom
            if (empty($prenom)) {
                $prenom_err = "Veuillez entrer un prénom.";
            }

            // Validate email
            if (empty($email)) {
                $email_err = "Veuillez entrer un email.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Veuillez entrer un email valide.";
            }

            // Validate password
            if (empty($password)) {
                $password_err = "Veuillez entrer un mot de passe.";
            } elseif (strlen($password) < 6) {
                $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
            }

            // Validate tel
            if (empty($tel)) {
                $tel_err = "Veuillez entrer un numéro de téléphone.";
            }

            // Validate adresse
            if (empty($adresse)) {
                $adresse_err = "Veuillez entrer une adresse.";
            }

            // Validate type
            if ($type != "etudiant" && $type != "prof") {
                $type_err = "Veuillez sélectionner un type.";
            }

            // Validate date_naissance
            if (empty($date_naissance)) {
                $date_naissance_err = "Veuillez entrer une date de naissance.";
            }

            $_SESSION["nom_err"] = $nom_err;
            $_SESSION["prenom_err"] = $prenom_err;
            $_SESSION["email_err"] = $email_err;
            $_SESSION["password_err"] = $password_err;
            $_SESSION["tel_err"] = $tel_err;
            $_SESSION["adresse_err"] = $adresse_err;
            $_SESSION["type_err"] = $type_err;
            $_SESSION["date_naissance_err"] = $date_naissance_err;

            $_SESSION["nom"] = $nom;
            $_SESSION["prenom"] = $prenom;
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            $_SESSION["tel"] = $tel;
            $_SESSION["adresse"] = $adresse;
            $_SESSION["type"] = $type;
            $_SESSION["date_naissance"] = $date_naissance;

            // Check input errors before inserting in database
            if (empty($nom_err) && empty($prenom_err) && empty($email_err) && empty($password_err) && empty($tel_err) && empty($adresse_err) && empty($type_err) && empty($date_naissance_err)) {
                $_SESSION["nom_err"] = $nom_err;
                $_SESSION["prenom_err"] = $prenom_err;
                $_SESSION["email_err"] = $email_err;
                $_SESSION["password_err"] = $password_err;
                $_SESSION["tel_err"] = $tel_err;
                $_SESSION["adresse_err"] = $adresse_err;
                $_SESSION["type_err"] = $type_err;
                $_SESSION["date_naissance_err"] = $date_naissance_err;
                // Prepare an insert statement
                if ($type=="etudiant"){
                    $sql = "INSERT INTO eleve (nomel, prenomel, date_naissance, adresse, telephone, password, email) VALUES (?, ?, ?, ?, ?, ?, ?)";
                } elseif ($type=="prof"){
                    $sql = "INSERT INTO prof (nom, prenom, adresse, telephone, password, email) VALUES (?, ?, ?, ?, ?, ?)";
                }
                
                $stmt = mysqli_prepare($conn, $sql);


                if ($stmt) {

                    if ($type=="etudiant"){
                        mysqli_stmt_bind_param($stmt, "ssisiss", $param_nom, $param_prenom, $param_date_naissance, $param_adresse, $param_tel, $param_password, $param_email);
                    } elseif ($type=="prof"){
                        mysqli_stmt_bind_param($stmt, "sssiss", $param_nom, $param_prenom, $param_adresse, $param_tel, $param_password, $param_email);
                    }
                    
               
                    // Bind variables to the prepared statement as parameters
                    // Set parameters
                    $param_nom = $nom;
                    $param_prenom = $prenom;
                    $param_email = $email;
                    $param_password = $password; // Creates a password hash
                    $param_tel = $tel;
                    $param_adresse = $adresse;
                    $param_type = $type;
                    $param_date_naissance = $date_naissance;

                    if ($type=="etudiant"){
                        if (mysqli_stmt_execute($stmt)){
                            $numel = mysqli_insert_id($conn);
                            mysqli_query($conn, "INSERT INTO login(Num,pseudo,passe,type) values('$numel','$prenom','$password','etudiant')");
                            header("location: /gestion00/pages/form/connexion.php");
                        } else {
                            echo "Quelque chose a mal tourné. Veuillez réessayer plus tard.";
                        }
                    } elseif ($type=="prof"){
                        if (mysqli_stmt_execute($stmt)) {
                            $numprof = mysqli_insert_id($conn);
                            mysqli_query($conn, "INSERT INTO login(Num,pseudo,passe,type) values('$numprof','$prenom','$password','prof')");
                            header("location: /gestion00/pages/form/connexion.php");
                        } else {
                            echo "Quelque chose a mal tourné. Veuillez réessayer plus tard.";
                        }
                    }
                }
            } else {
                header("location: /newgestion/pages/inscription.php");
            }

        }
    }

?>