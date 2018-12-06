<?php
	ini_set('display_errors', 1);
	require '../src/users.php';
	session_start();
	// retrieves the input from the register form in index.php and stores them in the 5 variables.
	$fname = $_POST['vnaam'];
	$suffix = $_POST['suffix'];
	$lname = $_POST['lnaam'];
	$email = $_POST['email'];
	$pass = $_POST['psw'];
	$user = new users();
	// sends user variable with the POST information to the update function in user.php and stores the result in $update
	$update = $user->update($_SESSION['login'], $fname, $suffix, $lname, $email, $pass);
	// checks if the update function executed with or without errors
	if ($update == true) {
		echo "Gelukt!";
		header("Location: ../accountSettings.php");
	} else {
		echo "Mislukt!";
	}

?>