<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
include_once 'picturedb.php';
// Create object of Users class
$picture = new Picture();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['picture_id'] ?? '');
// Get all or a single user from database
if ($api == 'GET') {
   
    if ($id != 0) {
       
        $image = $picture->getPictureById($id);
        var_dump( $image);
        die;
        $image['base64'] = base64_encode($image['picture_date']);
        echo json_encode($image);

    } else {

        $images = $picture->fetchAll();

        foreach ($images as &$image) {
            $image['base64'] = base64_encode($image['picture_date']);
        }

        unset($image);
       echo json_encode($images);
    }
}

/*    
if ($image) {
    // Déterminer le type MIME de l'image à partir de son nom
    $image_extension = pathinfo($image['picture_name'], PATHINFO_EXTENSION);
    $mime_type = match (strtolower($image_extension)) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        default => 'application/octet-stream', // Type par défaut
    };

    // Envoyer les bons en-têtes HTTP
    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: inline; filename="' . $image['picture_name'] . '"');
    header('Content-Length: ' . strlen($image['picture_date']));

    // Envoyer l'image*
    var_dump($image['picture_date']);
    
    echo $image['picture_date'];
} else {
    http_response_code(404);
    echo 'Image not found';
}  
}
 */


//----------------------



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['image'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Contrôles de sécurité
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($extension), $allowed_extensions)) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Invalid file type."]);
            exit;
        }

        if ($file['size'] > 5000000) { // Limite de 5 Mo
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "File size exceeds limit."]);
            exit;
        }

        // Lire le contenu de l'image
        $picture_name  = basename($file['tmp_name']);
        $picture_date = file_get_contents($file['tmp_name']);
        // érer dans la base de données
        $queryResults = $picture->insert($picture_name, $picture_date);
        http_response_code(200); // OK
        echo json_encode(["message" => "Image uploaded successfully!"]);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Failed to upload file."]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Only POST requests are allowed."]);
}


//---------------------------


if ($api == 'PUT') {
    $data = $picture->getPictureById($id);
    var_dump($data);
    if ($data != null) {
        $data = json_decode(file_get_contents('php://input'));
        $picture_name = $picture->test_input($data->picture_name);
        $picture_date = $picture->test_input($data->picture_date);


        if ($picture->update($picture_name, $picture_date, $id)) {
            http_response_code(202);
            echo $picture->message('picture updated successfully!', false);
        } else {
            http_response_code(400);
            echo $picture->message('Failed to update an picture!', true);
        }
    } else {
        http_response_code(404);
        echo $picture->message('picture not found!', true);
    }
}

// Delete an role from database
if ($api == 'DELETE') {
    $picture->delete($id);
    if ($id != null) {
        if ($picture->delete($id)) {

            echo $picture->message('picture deleted successfully!', false);
        } else {
            echo $picture->message('Failed to delete an picture!', true);
        }
    } else {
        echo $picture->message('picture not found!', true);
    }
}
