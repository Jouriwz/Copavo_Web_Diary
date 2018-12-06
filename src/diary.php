<?php

class diary {

	private function connect() {

	$servername = "localhost";
	$username =  "root";
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

	// creates a diary entry in the database using $createDiary in forms/createDiaryProcess to fill parameters
	public function createDiary($naam, $id_gebruiker) {
		$conn = $this->connect();
		// SQL query
		$sql = 'INSERT INTO dagboeken (naam) VALUES (:naam)';
		$stmt = $conn->prepare($sql);
		// binds the $naam parameter with the query (:value)
		$stmt->bindParam(':naam', $naam);
		if ($stmt->execute()) {
            // grabs the last inserted ID from the created diary
			$getLastId = $conn->LastinsertId();
			$sql2 = 'INSERT INTO gebruikers_dagboeken (id_dagboek, id_gebruiker) VALUES (:id_dagboek, :id_gebruiker)';
			$stmt = $conn->prepare($sql2);
			$stmt->bindParam(':id_dagboek', $getLastId);
			$stmt->bindParam(':id_gebruiker', $id_gebruiker);
			if ($stmt->execute()) {
				$conn = NULL;
				return true;
			}else {
				$conn = NULL;
				return false;
			}
		}else {
			$conn = NULL;
			return false;
		}
	}

	public function getAllDiaries($id_gebruiker) {
        // grabs all the diaries from the current logged in user
        $conn = $this->connect();
        // :id = current logged in user (session[login])
        $sql = 'SELECT dagboeken.id_dagboek, dagboeken.naam FROM dagboeken INNER JOIN gebruikers_dagboeken ON dagboeken.id_dagboek = gebruikers_dagboeken.id_dagboek WHERE gebruikers_dagboeken.id_gebruiker = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_gebruiker);
        $teller = 0;
        if ($stmt->execute()) {
            // $data, holds the value from the previous SQL query
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // $teller shows how many diaries there are.
                $teller++;
                echo '<form method="post" action="post.php">
                <input type="hidden" name="id_dagboek" value="' . $data['id_dagboek'] . '">
                <button>' . $teller.". " . $data['naam'] . '</button>
                </form>';
            }
            $conn = null;
        }else {
            $conn = null;
            return false;
        }
    }

	// create post function using the $_POST data from forms/createPostProcess to fill Parameters
	public function createPost($post, $id_dagboek) {
        $conn = $this->connect();
        // insert in the posts table
        $sql = 'INSERT INTO posts (post, datum) VALUES (:post, NOW());';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':post', $post);
        if($stmt->execute()) {
            // latInsertedId = id_post
            $lii = $conn->lastInsertId();
            $sql2 = 'INSERT INTO dagboeken_posts (id_post, id_dagboek) VALUES (:id_post, :id_dagboek)';
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindParam(':id_post', $lii);
            $stmt2->bindParam(':id_dagboek', $id_dagboek);
            if($stmt2->execute()) {
                $conn = NULL;
                return true;
            } else {
                $conn = NULL;
                return false;
            }
        } else {
            $conn = NULL;
            return false;
        }
    }

    public function getDiaryName($id_dagboek) {
        $conn = $this->connect();
        // gets the name of the diary where id_dagboek = id_dagboek
        $sql = 'SELECT naam FROM dagboeken WHERE id_dagboek = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_dagboek);
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn = null;
            return $data['naam'];
        } else {
            $conn = null;
            return false;
        }
    }

    public function getPostsName($id_post) {
        $conn = $this->connect();
        // gets the post name
        $sql = 'SELECT posts.id_post, posts.post, posts.datum FROM posts INNER JOIN dagboeken_posts ON posts.id_post = dagboeken_posts.id_post WHERE dagboeken_posts.id_dagboek = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_post);
        $teller = 1;
        if ($stmt->execute()) {
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // everytime a new post is made this will echo
                	echo"<tr>
                            <td><p>Post: ". $teller ."<br>". $data['datum'] ."<br>". $data['post'] .
                            "</td>
                        </tr>";
                    $teller++;
                }
                $total = $teller-1;
                echo " Totaal zijn er $total posts";
                $conn = null;

        }else {
                $conn = null;
                return false;
        }
    }

    public function deleteDiary($id_dagboek) {
                
                $conn = $this->connect();
                // gets the diary id post id
                $sql = 'SELECT posts.id_post FROM posts INNER JOIN dagboeken_posts ON dagboeken_posts.id_post = posts.id_post WHERE dagboeken_posts.id_dagboek = :id';
                $stmt = $conn->prepare($sql);
                print_r($id_dagboek);
                $stmt->bindParam(':id', $id_dagboek);

                if ($stmt->execute()) {
                    $data = $stmt->fetchall(PDO::FETCH_ASSOC);
                    $total = count($data);
                    for ($i=0; $i < $total;) {
                        $sql = 'DELETE FROM posts WHERE id_post = :id';
                        $sql2 = 'DELETE FROM dagboeken_posts WHERE id_post = :id';         
                        $id_post = $data[$i]['id_post'];
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id', $id_post);
                        $stmt->execute();
                        $stmt = $conn->prepare($sql2);
                        $stmt->bindParam(':id', $id_post);                    
                        $stmt->execute();
                        $i++;
                    }

        $sql = 'DELETE FROM dagboeken WHERE id_dagboek = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_dagboek);
        
        if ($stmt->execute()) {
            return true;
            $conn = NULL;
            } else{
        	  		return false;
    	  			$conn = NULL;      
            }    
        }
    }  

}


?>
