<?php
session_start();
ini_set('display_errors', 1);
$id_gebruiker = $_SESSION['login'];
require 'src/users.php';
$user = new users();
// gets the users current account informationa and sends it to the getUserData function with $id_gebruiker as the session
$user_data = $user->getUserData($id_gebruiker);
if (!isset($_SESSION['login'])) {
  header('Location: index.php');
}

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
    <link href="css/homelogin.css" rel="stylesheet">
  </head>

  <body class="text-center">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">My Diary</h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link active" href="#">Home</a>
            <a class="nav-link" href="dagboekHome.php">My Diary</a>
            <a class="nav-link" href="forms/logout.php">Logout</a>
          </nav>
        </div>
      </header>

      <form action="forms/accountSettingsProcess.php" method="post">
        <div class="container">
          <h1>Change your account information here!</h1>
          <label for="email"><b>E-Mail</b></label>
          <input type="email" name="email" value="<?php echo $user_data['Email']; ?>" required>

          <label for="vnaam"><b>First Name</b></label>
          <input type="text" placeholder="Enter First Name" name="vnaam" value="<?php echo $user_data['voornaam']; ?>" required>

          <label for="suffix"><b>suffix</b></label>
          <input type="text" placeholder="Enter Suffix" name="suffix" value="<?php echo $user_data['tussenvoegsels']; ?>">

          <label for="lnaam"><b>Last Name</b></label>
          <input type="text" placeholder="Enter Last Name" name="lnaam" value="<?php echo $user_data['achternaam']; ?>" required>

          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" value>

          <button type="submit">Change</button>
        </div>
      </form>

      <form action="forms/deleteAccountProcess.php" method="post">
        <div class="container">
           <button type="submit" class="btn btn-danger" name="deleteAccount">Delete Account!!!</button>
        </div>
      </form> 

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
