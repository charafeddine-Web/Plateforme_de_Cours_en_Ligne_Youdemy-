<?php
require_once '../autoload.php';
session_start();
use Classes\Cours_Text;
use Classes\Cours_Video;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitcours'])) {
    if (!isset($_SESSION['id_user'])) {
        echo "Error: User not logged in.";
        exit;
    }
    $title = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $type = htmlspecialchars($_POST['type']);
    $category_id = intval($_POST['categorie']);
    $enseignant_id = $_SESSION['id_user']; 
    $content = '';

    if ($type === 'video' && isset($_FILES['contenuVideo']) && $_FILES['contenuVideo']['error'] === 0) {
        $uploadDir = 'uploads/videos/';
        $uploadFile = $uploadDir . basename($_FILES['contenuVideo']['name']);
        if (move_uploaded_file($_FILES['contenuVideo']['tmp_name'], $uploadFile)) {
            $content = $uploadFile;
        } else {
            echo "Error uploading video.";
            exit;
        }
    } elseif ($type === 'text') {
        $content = htmlspecialchars($_POST['contenuText']);
    }

    if ($type === 'video') {
        $course = new Cours_Video($title, $description, $category_id, $enseignant_id, $content, $type);
    } else {
        $course = new Cours_Text($title, $description, $category_id, $enseignant_id, $content, $type);
    }

    if ($course->addCours()) {
        echo "Course added successfully.";
    } else {
        echo "Failed to add course.";
    }
}
