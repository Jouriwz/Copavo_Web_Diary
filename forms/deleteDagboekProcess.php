<?php
ini_set('display_errors', 1);
require '../src/diary.php';
session_start();
// stores the POST value from; post.php.
$id_dagboek = $_POST['id_dagboek'];
// new instance of diary   
$dagboek = new diary();
// stores paramenter value for deleteDiary function    
$delete = $dagboek->deleteDiary($id_dagboek);
    
    if ($delete == true) {
       echo "gelukt";
    } else {
        echo "Mislukt!";
    }
?>