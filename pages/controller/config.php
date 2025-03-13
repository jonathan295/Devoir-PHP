<?php

    // connexion à la base de données avec mysqli orienté objet
    $servername = "localhost";
    $password = "";
    $username = "root";
    $dbname = "gestion";

    $conn = mysqli_connect($servername, $username, $password, $dbname);


	// print_r($return);



    if (!$conn){
        die("Connection failed: ".mysqli_connect_error());
    } else {
        "Connecté avec succès";
    }

?>