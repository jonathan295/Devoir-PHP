<?php 

    include "config.php";
    global $conn;
    function req_mysql(PDO $conn, $req, $array, $fetchType) {
        $stmt = $conn->prepare($req);
        $stmt->execute($array);
    
        switch ($fetchType) {
            case PDO::FETCH_ASSOC:
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère un tableau associatif
            case PDO::FETCH_NUM:
                return $stmt->fetchAll(PDO::FETCH_NUM); // Récupère un tableau numérique
            case PDO::FETCH_BOTH:
                return $stmt->fetchAll(PDO::FETCH_BOTH); // Récupère un tableau associatif et numérique
            case PDO::FETCH_OBJ:
                return $stmt->fetchAll(PDO::FETCH_OBJ); // Récupère un tableau d'objets
            case PDO::FETCH_COLUMN:
                return $stmt->fetchColumn(); // Récupère la valeur d'une seule colonne
            default:
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Par défaut, un tableau associatif
        }
    }
    
    function show_result($results, $result,$url){
        foreach ($results as $result){
            echo '<li><a href="' . $url . $result['nom'] . '">' . $result['nom'] .'</a></li>';				
        }
    }
?>