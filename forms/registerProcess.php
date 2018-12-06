<?php
	ini_set('display_errors', 1);
	require '../src/users.php';
	// gets the input data from the form from index.php
	$fname = $_POST['vnaam'];
	$suffix = $_POST['suffix'];
	$lname = $_POST['lnaam'];
	$email = $_POST['email'];
	$pass = $_POST['psw'];
	// creates a new user and stores it in the veriable $user
	$user = new users();
	// sends the $user variable with the POST information to the parameters in the register function
	$register = $user->register($fname, $suffix, $lname, $email, $pass);

	// checks if the register function was executed with or without errors.
	if ($register == true) {
		header("Location: ../loginpage.php");
	} else {
		echo "Mislukt!";
	}

?>