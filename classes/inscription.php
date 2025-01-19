<?php

namespace Classes;

use Classes\DatabaseConnection;

 
class Inscription
{
    /**
     * Fetch all inscriptions with course, teacher, and student details.
     * 
     * @return array|false
     */
    public function getAllInscriptions()
    {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();

            $sql = "
                SELECT 
                    i.idInscription,
                    c.idCours,
                    c.titre AS course_title,
                    c.description AS course_description,
                    u_teacher.nom AS teacher_name,
                    u_teacher.prenom AS teacher_surname,
                    u_student.nom AS student_name,
                    u_student.prenom AS student_surname,
                    i.date_inscription
                FROM 
                    inscriptions i
                INNER JOIN 
                    cours c ON i.cours_id = c.idCours
                INNER JOIN 
                    users u_teacher ON c.enseignant_id = u_teacher.idUser
                INNER JOIN 
                    users u_student ON i.etudiant_id = u_student.idUser
                ORDER BY 
                    i.date_inscription DESC
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error fetching inscriptions: " . $e->getMessage();
            return false;
        }
    }

    public function inscrireEtudiant($coursId, $etudiantId) {
        $pdo = DatabaseConnection::getInstance()->getConnection();

        try {
            $query = "SELECT * FROM inscriptions WHERE cours_id = :cours_id AND etudiant_id = :etudiant_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['cours_id' => $coursId, 'etudiant_id' => $etudiantId]);

            if ($stmt->rowCount() > 0) {
                return "Vous êtes déjà inscrit à ce cours.";
            }
            $query = "INSERT INTO inscriptions (cours_id, etudiant_id) VALUES (:cours_id, :etudiant_id)";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['cours_id' => $coursId, 'etudiant_id' => $etudiantId]);

            return "Inscription réussie!";
        } catch (\PDOException $e) {
            return "Erreur lors de l'inscription: " . $e->getMessage();
        }
    }


    public function getAllInscriptionsEtudient($etudiantId) {
        $pdo = DatabaseConnection::getInstance()->getConnection();

        $sql = "SELECT c.course_name, c.course_description, c.instructor_name, c.start_date
                FROM inscriptions i
                JOIN courses c ON i.course_id = c.id
                WHERE i.student_id = :etudiantId";

        $stmt = $$pdo->prepare($sql);
        $stmt->bindParam(':etudiantId', $etudiantId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}