<?php 
	session_start();
	ini_set('displey_errors', 1);
	
	require '../src/diary.php';

	// data from post.php <form></form>
	$postText = $_POST['postText'];
	$id_dagboek = $_POST['id_dagboek'];

	$post = new diary();
	// data for the createPost paremeters
	$createPost = $post->createPost($postText, $id_dagboek);

	if ($createPost == true) {
		header("Location: ../dagboekHome.php");
	}else {
		echo "Mislukt";
	}

?>