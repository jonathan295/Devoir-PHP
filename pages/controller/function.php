<?php 

    require_once "config.php";

    function showItemNav($conn, $req, $varName) {
		$varName = mysqli_fetch_all(mysqli_query($conn, $req), MYSQLI_ASSOC);
        return $varName;
    }
    
    function show_result($results, $result,$url){
        foreach ($results as $result){
            echo '<li><a href="' . $url . $result['nom'] . '">' . $result['nom'] .'</a></li>';				
        }
    }
?>