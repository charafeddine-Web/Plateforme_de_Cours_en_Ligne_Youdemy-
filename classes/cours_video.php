<?php

namespace Classes;

use Classes\DatabaseConnection;
use Classes\Cours;
 
class Cours_Video extends Cours
{
    private $contenu;

    public function __construct($titre, $description, $categorie_id , $enseignant_id, $contenu,$type)
    {
        parent::__construct($titre, $description, $categorie_id, $enseignant_id,$type);
        $this->contenu = $contenu;
    }
    public function addCours()
    {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "INSERT INTO cours (titre, description, contenu, categorie_id, enseignant_id, type) 
                    VALUES (:titre, :description, :contenu, :categorie_id, :enseignant_id, :type)";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(':titre', $this->titre, \PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->description, \PDO::PARAM_STR);
            $stmt->bindParam(':contenu', $this->contenu, \PDO::PARAM_STR);
            $stmt->bindParam(':categorie_id', $this->categorie_id, \PDO::PARAM_INT);
            $stmt->bindParam(':enseignant_id', $this->enseignant_id, \PDO::PARAM_INT);
            $stmt->bindParam(':type', $this->type, \PDO::PARAM_STR);
    
            if ($stmt->execute()) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "SQL Error: " . $errorInfo[2];
                return false;
            }
        } catch (\PDOException $e) {
            echo "Error adding cours: " . $e->getMessage();
            return false;
        }
    }
    
    public function getAllCourss()
    {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT count(*) as res_cours_video FROM cours WHERE type = 'video'";
            $stmt = $pdo->prepare($sql);
    
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result;
            } else {
                return [
                    'res_cours_video' => 0
                ];
            }
        } catch (\PDOException $e) {
            echo "Error fetching cours: " . $e->getMessage();
            return false;
        }
    }
    public function getAllCours()
    {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "SELECT c.idCours,c.titre,c.description,c.type,ct.nom,ct.idCategory,c.date_creation FROM cours c 
            JOIN categories ct on ct.idCategory=c.categorie_id 
            WHERE type = 'video'";
            $stmt = $pdo->prepare($sql);
    
            $stmt->execute();
            return $stmt->fetchAll();
        
        } catch (\PDOException $e) {
            echo "Error fetching cours: " . $e->getMessage();
            return false;
        }
    }
}    