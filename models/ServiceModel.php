<?php

require "Database.php";


class ServiceModel extends Database
{

    public function getAll()
    {
        try {
            $sql = "SELECT * From services";
            $response = $this->connect()->prepare($sql);
            $response->execute();
            return $response->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function create($data)
    {
        $description = $data['description'];
        $price = $data['price'];
        $active = true;

        $sql = "INSERT INTO services (description, price, active) VALUES (:description, :price, :active)";
        $insert = $this->connect()->prepare($sql);
        $insert->bindParam(":description", $description, PDO::PARAM_STR);
        $insert->bindParam(":price", $price, PDO::PARAM_INT);
        $insert->bindParam(":active", $active, PDO::PARAM_INT);
        $insert->execute();
    }
}