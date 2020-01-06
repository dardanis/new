<?php

require "Database.php";


class UserModel extends Database
{

    public function getAll()
    {
        try {
            $sql = "SELECT * From users";
            $response = $this->connect()->prepare($sql);
            $response->execute();
            return $response->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }


    public function create($data)
    {
        $name = $data['name'];
        $password = hash('sha256', $data['password']);
        $email = $data['email'];

        $sql = "INSERT INTO users (name, password, email) VALUES (:name, :password, :email)";
        $insert = $this->connect()->prepare($sql);
        $insert->bindParam(":name", $name, PDO::PARAM_STR);
        $insert->bindParam(":password", $password, PDO::PARAM_STR);
        $insert->bindParam(":email", $email, PDO::PARAM_STR);
        $insert->execute();
        $userId = $this->connect()->lastInsertId();
        if (isset($data['shops']) && !empty($data['shops'])) {
            foreach ($data['shops'] as $shopId) {
                $sql = "INSERT INTO user_shops (user_id, shop_id) VALUES (:user_id, :shop_id)";
                $insertShop = $this->connect()->prepare($sql);
                $insertShop->bindParam(":user_id", $userId, PDO::PARAM_INT);
                $insertShop->bindParam(":shop_id", $shopId, PDO::PARAM_INT);
                $insertShop->execute();
            }
        }
    }

    public function update($data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $email = $data['email'];

        $sql = "UPDATE users set name = :name, email = :email WHERE id = :id";
        if(!empty($data['password']) && $data['password'] !== '0'){
            $password = hash('sha256', $data['password']);
            $sql = "UPDATE users set name = :name, email = :email, password = :password WHERE id = :id";
        }

        $insert = $this->connect()->prepare($sql);
        $insert->bindParam(":id", $id, PDO::PARAM_STR);
        $insert->bindParam(":name", $name, PDO::PARAM_STR);
        $insert->bindParam(":email", $email, PDO::PARAM_STR);
        if(!empty($data['password']) && $data['password'] !== '0'){
            $insert->bindParam(":password", $password, PDO::PARAM_STR);
        }
        $insert->execute();

        if(!isset($data['shops'])){
            $sqlUsers = "DELETE FROM user_shops WHERE user_id = :user_id";
            $usersShop = $this->connect()->prepare($sqlUsers);
            $usersShop->bindParam(":user_id", $id, PDO::PARAM_INT);
            $usersShop->execute();
        }else{
            $sqlUsers = "DELETE FROM user_shops WHERE user_id = :user_id";
            $usersShop = $this->connect()->prepare($sqlUsers);
            $usersShop->bindParam(":user_id", $id, PDO::PARAM_INT);
            $usersShop->execute();

            foreach ($data['shops'] as $shopId) {
                $sqlUser = "INSERT INTO user_shops (user_id, shop_id) VALUES (:user_id, :shop_id)";
                $insert = $this->connect()->prepare($sqlUser);
                $insert->bindParam(":user_id", $id, PDO::PARAM_INT);
                $insert->bindParam(":shop_id", $shopId, PDO::PARAM_INT);
                $insert->execute();
            }
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE users , user_shops  FROM users LEFT JOIN user_shops on users.id = user_shops.user_id
                WHERE users.id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function getUserShopsDropdown($userId)
    {
        try {
            $sql = "SELECT u.id, u.name FROM shops as u INNER JOIN user_shops us on u.id = us.shop_id WHERE us.user_id = :user_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $stmt->execute();

            $shops = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();
            foreach($shops as $shop){
                $response[] = array(
                    "id" => $shop['id'],
                    "text" => $shop['name']
                );
            }
            return $response;

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function userDropdown($data)
    {
        $records = 10;
        if(!isset($data['users'])){
            $stmt = $this->connect()->prepare("SELECT * FROM users ORDER BY name LIMIT :limit");
            $stmt->bindValue(':limit', (int)$records, PDO::PARAM_INT);
            $stmt->execute();
            $usersList = $stmt->fetchAll();
        }else{
            $search = $data['users'];// Search text
            $stmt = $this->connect()->prepare("SELECT * FROM users WHERE name like :name ORDER BY name LIMIT :limit");
            $stmt->bindValue(':name', '%'.$search.'%', PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int)$records, PDO::PARAM_INT);
            $stmt->execute();
            $usersList = $stmt->fetchAll();

        }

        $response = array();
        foreach($usersList as $user){
            $response[] = array(
                "id" => $user['id'],
                "text" => $user['name']
            );
        }
        echo json_encode($response);
    }

    public function shopsDropdown($data)
    {
        $records = 10;
        if(!isset($data['shops'])){
            $stmt = $this->connect()->prepare("SELECT * FROM shops ORDER BY name LIMIT :limit");
            $stmt->bindValue(':limit', (int)$records, PDO::PARAM_INT);
            $stmt->execute();
            $shopsList = $stmt->fetchAll();
        }else{
            $search = $data['shops'];// Search text
            $stmt = $this->connect()->prepare("SELECT * FROM shops WHERE name like :name ORDER BY name LIMIT :limit");
            $stmt->bindValue(':name', '%'.$search.'%', PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int)$records, PDO::PARAM_INT);
            $stmt->execute();
            $shopsList = $stmt->fetchAll();

        }

        $response = array();
        foreach($shopsList as $shop){
            $response[] = array(
                "id" => $shop['id'],
                "text" => $shop['name']
            );
        }
        echo json_encode($response);
    }
    
}