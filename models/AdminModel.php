<?php

class AdminModel extends Model 
{
    const SHOW_BY_DEFAULT = 3;

    public function add_task($title, $text, $name, $email)
    {
        //print_r (mysqli_connect('127.0.0.1', 'root', '', 'task_db'));
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

            header("Location: /bootstrap/admin");

		} else {

            return false;
            
        }
    }
        
    public function Performed($status,$id){

        $db = DB::connToDB();
        $sql = "UPDATE articles SET status = :status WHERE id = :id";
        $stmt = $db->prepare($sql);

        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result;

    }


    public function EditTask($id,$text){

        $db = DB::connToDB();
		$sql = "UPDATE articles SET text = :text WHERE id = :id";
        $stmt = $db->prepare($sql);

        $stmt->bindValue(":text", $text, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result;

    }

    public function EditAdmin($edit,$id){

        $db = DB::connToDB();
		$sql = "UPDATE articles SET edit = :edit WHERE id = :id";
        $stmt = $db->prepare($sql);

        $stmt->bindValue(":edit", $edit, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;

    }


    public function getAllProducts($sort) {

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

    public function getLimitProducts($leftLimit, $rightLimit, $sort, $page) {

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