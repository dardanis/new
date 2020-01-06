<?php

require "Database.php";

class ShopModel extends Database
{

    public function getAll()
    {
        try {
            $userId = $_SESSION['user_id'];
            $sql = "SELECT sh.id, sh.name, sh.city_id, us.user_id, c.name as city_name
                 FROM shops AS sh LEFT JOIN user_shops AS us ON sh.id = us.shop_id
                LEFT JOIN city AS c ON sh.city_id = c.id WHERE us.user_id = :id";
            $response = $this->connect()->prepare($sql);
            $response->bindParam(":id", $userId, PDO::PARAM_INT);
            $response->execute();

            return $response->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $sql = "SELECT * FROM shops WHERE id = :id";
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
        try {
            $name = $data['name'];
            $cityId = $data['city_id'];

            $sql = "INSERT INTO shops (name, city_id) VALUES (:name, :city_id)";

            $insert = $this->connect()->prepare($sql);
            $insert->bindParam(":name", $name, PDO::PARAM_STR);
            $insert->bindParam(":city_id", $cityId, PDO::PARAM_INT);
            $insert->execute();
            $shopId = $this->connect()->lastInsertId();
            if (isset($data['users']) && !empty($data['users'])) {
                foreach ($data['users'] as $userId) {
                    $sql = "INSERT INTO user_shops (user_id, shop_id) VALUES (:user_id, :shop_id)";
                    $insert = $this->connect()->prepare($sql);
                    $insert->bindParam(":user_id", $userId, PDO::PARAM_INT);
                    $insert->bindParam(":shop_id", $shopId, PDO::PARAM_INT);
                    $insert->execute();
                }
            }

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function update($data)
    {
        try{
            $shopId = $data['id'];
            $name = $data['name'];
            $cityId = $data['city_id'];

            $sql = "UPDATE shops set name = :name, city_id = :city_id WHERE id = :id";

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $shopId, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":city_id", $cityId, PDO::PARAM_STR);
            $stmt->execute();

            if(!isset($data['users'])){
                $sqlUsers = "DELETE FROM user_shops WHERE shop_id = :shop_id";
                $usersShop = $this->connect()->prepare($sqlUsers);
                $usersShop->bindParam(":shop_id", $shopId, PDO::PARAM_INT);
                $usersShop->execute();
            }else{
                $sqlUsers = "DELETE FROM user_shops WHERE shop_id = :shop_id";
                $usersShop = $this->connect()->prepare($sqlUsers);
                $usersShop->bindParam(":shop_id", $shopId, PDO::PARAM_INT);
                $usersShop->execute();

                foreach ($data['users'] as $userId) {
                    $sqlUser = "INSERT INTO user_shops (user_id, shop_id) VALUES (:user_id, :shop_id)";
                    $insert = $this->connect()->prepare($sqlUser);
                    $insert->bindParam(":user_id", $userId, PDO::PARAM_INT);
                    $insert->bindParam(":shop_id", $shopId, PDO::PARAM_INT);
                    $insert->execute();
                }
            }

        } catch(PDOException $ex){
            echo "Error: ".$ex->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE shops , user_shops  FROM shops LEFT JOIN user_shops on shops.id = user_shops.shop_id
            WHERE shops.id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }

    }

    public function cityDropdown()
    {
        $sql = "SELECT * FROM city";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = array();
        foreach($cities as $city){
            $response[] = array(
                "id" => $city['id'],
                "text" => $city['name']
            );
        }
        return $response;
    }

    public function getShopUsersDropdown($shopId)
    {
        try {
            $sql = "SELECT u.id, u.name FROM users as u INNER JOIN user_shops us on u.id = us.user_id WHERE us.shop_id = :shop_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":shop_id", $shopId, PDO::PARAM_INT);
            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();
            foreach($users as $user){
                $response[] = array(
                    "id" => $user['id'],
                    "text" => $user['name']
                );
            }
            return $response;

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
}
