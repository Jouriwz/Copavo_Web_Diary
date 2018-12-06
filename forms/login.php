<?php
   session_start();
   
	ini_set('display_errors', 1);
	require '../src/users.php';
	// holds the input information from the form in loginpage.php
	$email = $_POST['email'];
	$pass = $_POST['psw'];
	// creates a new 
	$user = new users();
	// sends the POST information to the parameters in the login function
	$login = $user->login($email, $pass);
	// checks if the login function was executed with or without errors
	if ($login == true) {
		header('Location: ../dagboekHome.php');
	} else {
		header('Location: ../loginpage.php');
	}



?>