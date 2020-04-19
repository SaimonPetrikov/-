<?php
class IndexModel extends Model {

    const SHOW_BY_DEFAULT = 3;

    public function add_task($title, $text, $name, $email)
    {
        $db = DB::connToDB();
        
        $sql = "INSERT INTO articles (title, text, name, email) VALUES (:title, :text, :name, :email)";
        $result = $db->prepare($sql);
        
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        return $result->execute();
    }


    public function checkUser($name,$password) {

        $db = DB::connToDB();

		$sql = "SELECT * FROM user WHERE name = :name AND password = :password";

		$stmt = $db->prepare($sql);
		$stmt->bindValue(":name", $name, PDO::PARAM_STR);
		$stmt->bindValue(":password", $password, PDO::PARAM_STR);
		$stmt->execute();

        $res = $stmt->fetch();
        

		if(!empty($res)) {

            $_SESSION['user'] = $_POST['login'];
            $_SESSION['user'] = $_REQUEST['password'];

            header("Location: /bootstrap/admin");

        } else {

            return false;

        }

	}


    public function getAllTask($sort) {

        $result = array();
        
        $db = DB::connToDB();
        
        $sql = "SELECT * FROM articles ORDER BY id ASC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $result[$row['id']] = $row;

        }

        return $result;
    }

    public function getLimitTask($leftLimit, $rightLimit, $sort, $page) {

        $limit = self::SHOW_BY_DEFAULT;

        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = DB::connToDB();

        $sql = "SELECT * FROM articles ORDER BY $sort ASC LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $result[$row['id']] = $row;

        }
        
        return $result;
    }
    
}