<?php

namespace Classes;

use Classes\DatabaseConnection;
use PDO;
abstract class Cours
{
    protected $idCours;
    protected $titre;
    protected $description;
    protected $categorie_id;
    protected $enseignant_id;
    protected $type;
    protected $tags;

    public function __construct($titre, $description, $categorie_id = null, $enseignant_id,$type,$tags)
    {
        $this->titre = $titre;
        $this->description = $description;
        $this->categorie_id = $categorie_id;
        $this->enseignant_id = $enseignant_id;
        $this->type = $type;
        $this->tags = $tags;
    }
    public abstract function addCours();

    public static function ViewStatisticcours() {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $query = "
            SELECT COUNT(*) AS total_cours FROM cours
        ";
        
        
            $stmt = $pdo->query($query);
    
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result;
            } else {
                return [
                    'total_cours' => 0
                ];
            }
        } catch (\PDOException $e) {
            echo "Error retrieving statistics: " . $e->getMessage();
            return false; 
        }
    }

    // public static function updateCours($idCours, $titre, $description, $contenu, $categorie_id,$type)
    // {
    //     try {
    //         $pdo = DatabaseConnection::getInstance()->getConnection();
    //         $sql = "UPDATE cours 
    //                 SET titre = :titre, description = :description, contenu = :contenu, categorie_id = :categorie_id , type= :type
    //                 WHERE idCours = :idCours";
    //         $stmt = $pdo->prepare($sql);

    //         $stmt->bindParam(':idCours', $idCours, \PDO::PARAM_INT);
    //         $stmt->bindParam(':titre', $titre, \PDO::PARAM_STR);
    //         $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
    //         $stmt->bindParam(':contenu', $contenu, \PDO::PARAM_STR);
    //         $stmt->bindParam(':categorie_id', $categorie_id, \PDO::PARAM_INT);
    //         $stmt->bindParam(':type', $type);

    //         return $stmt->execute();
    //     } catch (\PDOException $e) {
    //         echo "Error updating cours: " . $e->getMessage();
    //         return false;
    //     }
    // }

    public static function deleteCours($idCours)
    {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "DELETE FROM cours WHERE idCours = :idCours";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':idCours', $idCours, \PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error deleting cours: " . $e->getMessage();
            return false;
        }
    }

    public abstract function getAllCours();
  
    public static function getCoursById($idCours)
    {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "
                SELECT 
                    c.idCours, 
                    c.titre, 
                    c.description, 
                    c.contenu, 
                    c.type, 
                    c.date_creation, 
                    u.nom AS enseignant_nom, 
                    ca.nom AS categorie_nom
                FROM cours c
                LEFT JOIN users u ON c.enseignant_id = u.idUser
                LEFT JOIN categories ca ON c.categorie_id = ca.idCategory
                WHERE c.idCours = :idCours
            ";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idCours', $idCours, \PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error fetching cours details: " . $e->getMessage();
            return false;
        }
    }

    public static function SearchCours($searchQuery, $page = 1, $limit = 8)
    {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
    
            $offset = ($page - 1) * $limit;
                $sql = "SELECT c.idCours, c.titre, c.description, c.type, c.categorie_id, c.enseignant_id, 
                           ct.nom AS category, c.date_creation, 
                           CONCAT(u.nom, ' ', u.prenom) AS fullname, 
                           GROUP_CONCAT(t.nom SEPARATOR ', ') AS tags
                    FROM cours c
                    INNER JOIN users u ON u.idUser = c.enseignant_id
                    INNER JOIN categories ct ON c.categorie_id = ct.idCategory
                    LEFT JOIN cours_tags ctg ON ctg.cours_id = c.idCours
                    LEFT JOIN tags t ON t.idTag = ctg.tag_id
                    WHERE c.titre LIKE :search OR c.description LIKE :search
                    GROUP BY c.idCours, c.titre, c.description, c.type, c.categorie_id, c.enseignant_id, ct.nom, c.date_creation, u.nom, u.prenom
                    ORDER BY c.date_creation
                    LIMIT :limit OFFSET :offset";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':search', '%' . $searchQuery . '%', \PDO::PARAM_STR);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo "Error fetching courses: " . $e->getMessage();
            return false;
        }
    }
    
public static function getTotalCoursesserch($searchQuery)
{
    $pdo = DatabaseConnection::getInstance()->getConnection();
    $query = "SELECT COUNT(*) FROM cours WHERE titre LIKE :search OR description LIKE :search";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':search', '%' . $searchQuery . '%');
    $stmt->execute();
    return $stmt->fetchColumn();
}


    // public static function ShowCours($page = 1, $limit = 8)
    // {
    //     try {
    //         $pdo = DatabaseConnection::getInstance()->getConnection();
            
    //         // Calculate the starting point for pagination
    //         $offset = ($page - 1) * $limit;
            
    //         $sql = "SELECT c.idCours, c.titre, c.description, c.type,c.categorie_id, c.enseignant_id ct.nom AS category, c.date_creation, 
    //                        CONCAT(u.nom, ' ', u.prenom) AS fullname, GROUP_CONCAT(t.nom SEPARATOR ', ') AS tags
    //                 FROM cours c
    //                 INNER JOIN users u ON u.idUser = c.enseignant_id
    //                 INNER JOIN categories ct ON c.categorie_id = ct.idCategory
    //                 LEFT JOIN cours_tags ctg ON ctg.cours_id = c.idCours
    //                 LEFT JOIN tags t ON t.idTag = ctg.tag_id
    //                 GROUP BY c.idCours
    //                 ORDER BY c.date_creation
    //                 LIMIT :limit OFFSET :offset";
            
    //         $stmt = $pdo->prepare($sql);
    //         $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
    //         $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
    //         $stmt->execute();
    //         return $stmt->fetchAll();
    //     } catch (\PDOException $e) {
    //         echo "Error fetching courses: " . $e->getMessage();
    //         return false;
    //     }
    // }
    public static function ShowCours($page = 1, $limit = 8)
{
    try {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        
        // Calculate the starting point for pagination
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT c.idCours, c.titre, c.description, c.type, c.categorie_id, c.enseignant_id, 
                       ct.nom AS category, c.date_creation, 
                       CONCAT(u.nom, ' ', u.prenom) AS fullname, 
                       GROUP_CONCAT(t.nom SEPARATOR ', ') AS tags
                FROM cours c
                INNER JOIN users u ON u.idUser = c.enseignant_id
                INNER JOIN categories ct ON c.categorie_id = ct.idCategory
                LEFT JOIN cours_tags ctg ON ctg.cours_id = c.idCours
                LEFT JOIN tags t ON t.idTag = ctg.tag_id
                GROUP BY c.idCours, c.titre, c.description, c.type, c.categorie_id, c.enseignant_id, ct.nom, c.date_creation, u.nom, u.prenom
                ORDER BY c.date_creation
                LIMIT :limit OFFSET :offset";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        echo "Error fetching courses: " . $e->getMessage();
        return false;
    }
}


public static function getTotalCourses()
{
    try {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $sql = "SELECT COUNT(*) FROM cours";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['COUNT(*)'];
    } catch (\PDOException $e) {
        echo "Error fetching total courses: " . $e->getMessage();
        return 0;
    }
}


    public static function staticCours(){
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "
            SELECT 
                (SELECT COUNT(*) FROM cours) AS total_cours,
                (SELECT COUNT(*) FROM users WHERE idRole = 2) AS total_etudiants,
                (SELECT COUNT(*) FROM inscriptions WHERE DATE(date_inscription) = CURDATE()) AS nouveaux_etudiants
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();
    
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return [
            'total_cours' => $result['total_cours'],
            'total_etudiants' => $result['total_etudiants'],
            'nouveaux_etudiants' => $result['nouveaux_etudiants']
        ];
    }
    
    public function getId()
    {
        return $this->idCours;
    }
}
