<?php
// Autoriser les requêtes provenant de tous les domaines
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Répondre à la requête préliminaire si la méthode est OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Inclure le fichier picturedb.php
include_once 'picturedb.php';
$picture = new Picture();

// Obtenir la méthode HTTP
$api = $_SERVER['REQUEST_METHOD'];

// Obtenir l'ID depuis l'URL
$id = intval($_GET['picture_id'] ?? '');

// Récupérer une ou plusieurs images
if ($api == 'GET') {
    if ($id != 0) {
        $data = $picture->getPictureById($id);
    } else {
        $data = $picture->fetchAll();
    }
    echo json_encode($data);
}

// Ajouter une nouvelle image
if ($api == 'POST') {
    // Vérification des données
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode([
            "message" => "Fichier manquant ou erreur lors du téléversement!",
            "error" => true,
            "details" => $_FILES
        ]);
        exit;
    }
    if (!isset($_POST['picture_name'])) {
        echo json_encode([
            "message" => "Le nom de l'image est manquant!",
            "error" => true,
            "details" => $_POST
        ]);
        exit;
    }

    // Traitement des données valides
    $pictureName = $picture->test_input($_POST['picture_name']);
    $pictureData = file_get_contents($_FILES['file']['tmp_name']);

    if ($picture->insert($pictureName, $pictureData)) {
        echo $picture->message('Image ajoutée avec succès!', false);
    } else {
        http_response_code(500);
        echo $picture->message('Échec de l\'ajout de l\'image!', true);
    }
}



// Supprimer une image
if ($api == 'DELETE') {
    if ($id != 0) {
        if ($picture->delete($id)) {
            echo $picture->message('Image supprimée avec succès!', false);
        } else {
            echo $picture->message('Échec de la suppression de l\'image!', true);
        }
    } else {
        http_response_code(404);
        echo $picture->message('Image introuvable!', true);
    }
}
