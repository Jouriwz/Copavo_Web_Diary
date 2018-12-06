<?php
session_start();
// als hij niet in een session login is dan relocate hij hem terug naar index.php
if (!isset($_SESSION['login'])) {
  header('Location: index.php');
}
require 'src/diary.php';
// creates a new instance of diary
$dagboek = new diary(); 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Diary</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/creatediary.css" rel="stylesheet">
  </head>

  <body class="text-center">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">My Diary</h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link active" href="#">Home</a>
            <a class="nav-link" href="accountSettings.php">Account</a>
            <a class="nav-link" href="forms/logout.php">Logout</a>
          </nav>
        </div>
      </header>

      <h2>Welcome</h2>
      <form class="margin-top" action="forms/createDiaryProcess.php" method="post">
        <div class="container">
          <label for="dagboek"><h1><b>Create Diary</b></h1></label>
          <input type="text" placeholder="Enter Diary name" name="dagboek" required>
          <button type="submit">Create</button>
        </div>
      </form>

          <div>
            <?php
            // shows the created diaries with the getAllDiaries function.
            $dagboek->getAllDiaries($_SESSION['login']);
            ?>
          </div>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>My Diary <a href="https://getbootstrap.com/">Bootstrap</a>, by <a href="#">Jouri</a>.</p>
        </div>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
