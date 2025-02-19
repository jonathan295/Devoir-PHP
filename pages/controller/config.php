<?php

    $servername = "localhost";
    $dbname = "gestion";
    $username = "root";
    $password = "";

    try{
        global $conn;
        $conn = new PDO("mysql:hostname=$servername;dbname=$dbname;charset=utf8", $username, $password);

    }catch (Exception $e){
        die("Error: {$e->getMessage()}");
    }

?>