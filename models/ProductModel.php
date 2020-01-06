<?php

require "Database.php";


class ProductModel extends Database
{

    public function getAll()
    {
        try {
            $sql = "SELECT * From products";
            $response = $this->connect()->prepare($sql);
            $response->execute();
            return $response->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function create($data)
    {

    }
}