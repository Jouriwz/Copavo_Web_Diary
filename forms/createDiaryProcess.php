<?php
	session_start();
	ini_set('display_errors', 1);
	
	require '../src/diary.php';
	// retrieves the name value from dagboekHome.php form POST
	$dboek = $_POST['dagboek'];
	
	$diary = new diary();
	// fills the $naam, id_gebruiker parementer with the $dkoek, S_SESSION['login'] values
	$createDiary = $diary->createDiary($dboek, $_SESSION['login']);

	if ($createDiary == true) {
		header("Location: ../dagboekHome.php");
	} else {
		echo "Mislukt!";
	}


?>