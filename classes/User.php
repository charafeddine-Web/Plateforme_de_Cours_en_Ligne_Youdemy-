<?php
namespace Classes;
use Classes\DatabaseConnection;
use PDO;

class User{
    protected $idUser;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $password;
    protected $idRole;


    public function __construct($idUser,$nom,$prenom,$email,$idRole){
        $this->idUser=$idUser; 
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->email=$email;
        $this->idRole=$idRole;
    }

    
    public static function login($email, $password) {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            if (!$pdo) {
                return "Erreur de connexion à la base de données.";
            }
    
            $query = "SELECT idUser, idRole, nom, prenom, password FROM users WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // Debug logs
                error_log("Stored hashed password: " . $user['password']);
                error_log("Password entered: " . $password);
                
                if (password_verify($password, $user['password'])) {
                    return $user; 
                } else {
                    error_log("Password verification failed for email: " . $email);
                    return "Mot de passe incorrect.";
                }
            } else {
                error_log("User not found for email: " . $email);
                return "Utilisateur introuvable avec cet email.";
            }
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return "Une erreur est survenue lors de la connexion.";
        }
    }
    
    


public static function logout() {
    session_start();
    if (isset($_SESSION['idUser'])) {  
        session_unset();  
        session_destroy();  
        header("Location: ../index.php");  
        exit();
    }
}

public function getIdUser() {
    return $this->idUser;
}
public function setIdUser($idUser) {
    $this->idUser = $idUser;
}

public function getNom() {
    return $this->nom;
}

public function setNom($nom) {
    $this->nom = $nom;
}
public function getPrenom() {
    return $this->prenom;
}

public function setPrenom($prenom) {
    $this->prenom = $prenom;
}

public function getEmail() {
    return $this->email;
}

public function setEmail($email) {
    $this->email = $email;
}

public function getIdRole() {
    return $this->idRole;
}
public function setIdRole($idRole) {
    $this->idRole = $idRole;
}
}