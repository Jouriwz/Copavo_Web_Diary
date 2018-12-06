<?php
session_start();
ini_set('displey_errors', 1);

require '../src/users.php';
// creates a new instance of the class
$delete = new users();
// stores data for the deleteAccount Parameter
$deleteDag = $delete->deleteAccount($_SESSION['login']);

if ($deleteDag == true) {
		session_unset();
		header("Location: ../index.php");
		
	}else {
		echo "Mislukt";
	}


?>