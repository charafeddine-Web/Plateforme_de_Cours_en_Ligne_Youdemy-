<?php

namespace Classes;


use Classes\User;
use Classes\DatabaseConnection;

class Admin extends User {
    public function ViewStatistic() {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $query = "
            SELECT 
                (SELECT COUNT(*) FROM users where idRole = 2) AS total_enseignant,
                (SELECT COUNT(*) FROM users where idRole = 3) AS total_etudient,
                (SELECT COUNT(*) FROM Vehicle) AS total_vehicles,
                (SELECT COUNT(*) FROM Reservation) AS total_reservations,
                (SELECT COUNT(*) FROM Reservation WHERE status = 'pending') AS total_res_pen,
                (SELECT COUNT(*) FROM Reservation WHERE status = 'accepted') AS total_res_acc,
                (SELECT COUNT(*) FROM Reservation WHERE status = 'rejected') AS total_res_ref
        ";
        
            $stmt = $pdo->query($query);
    
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result;
            } else {
                return [
                    'total_users' => 0,
                    'total_vehicles' => 0,
                    'total_reservations' => 0,
                    'total_res_pen' => 0,
                    'total_res_acc' => 0,
                    'total_res_ref' => 0,
                ];
            }
        } catch (\PDOException $e) {
            echo "Error retrieving statistics: " . $e->getMessage();
            return false; 
        }
    }
    
    
}
