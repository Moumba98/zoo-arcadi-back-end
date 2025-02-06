<?php

// Autoriser les requêtes provenant de tous les domaines
header("Access-Control-Allow-Origin: http://localhost:4200");

// Autoriser les méthodes HTTP spécifiques
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

// Autoriser les en-têtes spécifiques, y compris Content-Type
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Répondre à la requête préliminaire si la méthode est OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}


// Include action.php file
include_once 'noticedb.php';
// Create object of Users class
$notice = new Notice();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['notice_id'] ?? '');


// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $notice->getNoticeById($id);
	} else {
		$data = $notice->fetchAll();
	}
	echo json_encode($data);
}

// Add a new user into database
if ($api == 'POST') {
	$data = json_decode(file_get_contents('php://input'));
	$pseudo = $notice->test_input($data->pseudo);
	$comment = $notice->test_input($data->comment);
	$isvisible = $notice->test_input($data->isvisible);
	if ($notice->insert($pseudo,  $comment, $isvisible)) {
		echo $notice->message('notice added successfully!', false);
	} else {
		echo $notice->message('Failed to add an notice!', true);
	}
}

// Update an user in database
if ($api == 'PUT') {
	$data = $notice->getNoticeById($id);
	if ($data != null) {
		$data = json_decode(file_get_contents('php://input'));
		$pseudo = $notice->test_input($data->pseudo);
		$comment = $notice->test_input($data->comment);
		$isvisible = $notice->test_input($data->isvisible);
		if ($notice->update($pseudo, $comment, $isvisible, $id)) {
			http_response_code(202);
			echo $notice->message('notice updated successfully!', false);
		} else {
			http_response_code(400);
			echo $notice->message('Failed to update an notice!', true);
		}
	} else {
		http_response_code(404);
		echo $notice->message('notice not found!', true);
	}
}

// Delete an user from database
if ($api == 'DELETE') {
	$notice->delete($id);
	if ($id != null) {
		if ($notice->delete($id)) {

			echo $notice->message('notice deleted successfully!', false);
		} else {
			echo $notice->message('Failed to delete an notice!', true);
		}
	} else {
		echo $notice->message('notice not found!', true);
	}
}
