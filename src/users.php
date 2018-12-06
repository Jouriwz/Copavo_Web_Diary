<?php

class users {

	private function connect() {

		$servername = "localhost";
		$username = "root";
		$password = "admin-02";

		try {
		    $conn = new PDO("mysql:host=$servername;dbname=diary", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    return $conn;
			}

		catch(PDOException $e)
		    {
		    return $e->getMessage();
		    }
	}

	// registers new users using the POST data from registerProcess.php
	public function register($vnaam, $suffix, $anaam, $email, $psw) {

	 	$conn = $this->connect();
        $sql2 = 'SELECT * FROM gebruikers WHERE email = :email';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':email', $email);
        $stmt2->execute();
        $rows = $stmt2->fetch(PDO::FETCH_ASSOC);
        $countedRows = count($rows);
		// $password stores the encrypted $psw value
		$password = password_hash($psw, PASSWORD_BCRYPT, ['cost' => 12]);
		// inserts into the table gebruikers(column name,) with the values(:values)
		$sql = 'INSERT INTO gebruikers (voornaam, tussenvoegsels, achternaam, Email, wachtwoord) VALUES (:vnaam, :tv, :anaam, :Email, :psw)';
		// prepares the $sql query
		$stmt = $conn->prepare($sql);
		// binds the sql values with the functions parameters
		$stmt->bindParam(':vnaam', $vnaam);
		$stmt->bindParam(':tv', $suffix);
		$stmt->bindParam(':anaam', $anaam);
		$stmt->bindParam(':Email', $email);
		$stmt->bindParam(':psw', $password);
		// executes the function and ends the connection
		 if ($countedRows >= 2) {
            return true;
            $conn = NULL;
        }else {
            if ($stmt->execute()) {
                return true;
                $conn = NULL;
            }
            else {
                return false;
                $conn = NULL;
            }
        }
    }

	// function for login using $email and $pass as parameters with the $_POST value from forms/login.php
	public function login($email, $pass) {

        $conn = $this->connect();
        $sql = 'SELECT id_gebruiker, wachtwoord FROM gebruikers WHERE Email = :Email';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":Email", $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() == 1) {
            $conn = null;
            if (password_verify($pass, $data['wachtwoord'])) {
                $_SESSION['login'] = $data['id_gebruiker'];
                return true;
            } else {
                return false;
            }
        }
    }

    // update user data function using the $_POST values from forms/accountSettingsProcess.php to fill the parameters
    public function update($id_gebruiker, $voornaam, $tussenvoegsels, $achternaam, $Email, $wachtwoord) {

    	// incrypts the new password using bcrypt
    	$wachtwoord = password_hash($wachtwoord, PASSWORD_BCRYPT, ['cost' => 12]);
    	$conn = $this->connect();
    	$sql = 'UPDATE gebruikers SET voornaam = :voornaam, tussenvoegsels = :tussenvoegsels, achternaam = :achternaam, Email = :Email, wachtwoord = :wachtwoord WHERE id_gebruiker = :id_gebruiker';
    	$stmt = $conn->prepare($sql);
    	$stmt->bindParam(':voornaam', $voornaam);
    	$stmt->bindParam(':tussenvoegsels', $tussenvoegsels);
    	$stmt->bindParam(':achternaam', $achternaam);
    	$stmt->bindParam(':Email', $Email);
    	$stmt->bindParam(':wachtwoord', $wachtwoord);
    	$stmt->bindParam(':id_gebruiker', $id_gebruiker);
    	if ($stmt->execute()) {
			$conn = NULL;
			return true;
		}else {
			$conn = NULL;
			return false;
		}
    }

    // Shows user information in the form on the account page using the user_data variable on accountSettings.php
    public function getUserData($id_gebruiker) {

    	$conn = $this->connect();
    	$sql = 'SELECT voornaam, tussenvoegsels, achternaam, Email FROM gebruikers WHERE id_gebruiker = :id';
    	$stmt = $conn->prepare($sql);
    	$stmt->bindParam(':id', $id_gebruiker);
    	if ($stmt->execute()) {
    		$data = $stmt->fetch(PDO::FETCH_ASSOC);
    		$conn = null;
    		return $data;
    	} else {
    		$conn = null;
    		return false;
    	}
    }

    public function deleteAccount($id_gebruiker) {

        $conn = $this->connect();
        $sql = 'SELECT id_gebruiker FROM gebruikers_dagboeken WHERE id_gebruiker = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_gebruiker);
        $stmt->execute();
        // $data holds the output from the sql query
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // checks how many elements there ar e in $data
        if (sizeof($data) > 0){
        
                $conn = $this->connect();
                // grabs everything from the logged in user
                $sql = 'SELECT dagboeken.id_dagboek, posts.id_post FROM gebruikers
                        INNER JOIN gebruikers_dagboeken ON gebruikers_dagboeken.id_gebruiker = gebruikers.id_gebruiker
                        INNER JOIN dagboeken ON dagboeken.id_dagboek = gebruikers_dagboeken.id_dagboek
                        INNER JOIN dagboeken_posts ON dagboeken_posts.id_dagboek = dagboeken.id_dagboek
                        INNER JOIN posts ON posts.id_post = dagboeken_posts.id_post
                        WHERE gebruikers.id_gebruiker = :id';
                $stmt = $conn->prepare($sql);
                // binds id to session['login'] the logged in user
                $stmt->bindParam(':id', $id_gebruiker);

                if ($stmt->execute()) {
                    // $data holds the output from the previous sql query
                    $data = $stmt->fetchall(PDO::FETCH_ASSOC);
                    // counts the elements in $data and puts them in the $total var
                    $total = count($data);
                    for ($i=0; $i < $total;) {
                        // queries to delete
                        $sql = 'DELETE FROM posts WHERE id_post = :id';
                        $sql2 = 'DELETE FROM dagboeken_posts WHERE id_post = :id';         
                        // grabs the post id linked to the logged in user from the first query
                        $id_post = $data[$i]['id_post'];
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id', $id_post);
                        $stmt->execute();
                        $stmt = $conn->prepare($sql2);
                        $stmt->bindParam(':id', $id_post);                    
                        $stmt->execute();
                        $i++;
                    }
                    // grabs all the diaries
                    $sql2 = 'SELECT dagboeken.id_dagboek FROM dagboeken INNER JOIN gebruikers_dagboeken ON gebruikers_dagboeken.id_dagboek = dagboeken.id_dagboek WHERE gebruikers_dagboeken.id_gebruiker = :id';
                    $stmt2 = $conn->prepare($sql2);
                    // where id = the logged in user
                    $stmt2->bindParam(':id', $id_gebruiker);
                    $stmt2->execute();
                    // holds the data from $sql2
                    $data_dagboek = $stmt2->fetchall(PDO::FETCH_ASSOC);
                    // counts how many elements there are in $data_dagboek
                    $totale = count($data_dagboek);

                       for ($i=0; $i < $totale;) {                        
                            $sql = 'DELETE FROM dagboeken WHERE id_dagboek = :id';
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':id', $data_dagboek[$i]['id_dagboek']);
                            $stmt->execute();
                            $sql = 'DELETE FROM gebruikers_dagboeken WHERE id_dagboek = :id';
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':id', $data_dagboek[$i]['id_dagboek']);
                            $stmt->execute();
                            $i++;
                            }
                    // deletes the user
                    $sql = 'DELETE FROM gebruikers WHERE id_gebruiker = :id';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $id_gebruiker);
                    $stmt->execute();

                    return true;
                }else {
                    return false;
                    $conn = NULL;
                }    
                return true;
                $conn = NULL;
        }else {
            return false;
            $conn = NULL;
        }        
    }

}

 ?>
