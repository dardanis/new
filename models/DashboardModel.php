<?php

require "Database.php";


class DashboardModel extends Database
{
    public function getTopSoldServices()
    {
        try {
            $sql = "SELECT u.id, u.service_id, s.description, COUNT(*) as top_sold
                FROM user_sales as u INNER join services s on u.service_id = s.id
                GROUP BY service_id";
            $response = $this->connect()->prepare($sql);
            $response->execute();
            return $response->fetch();

        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
}