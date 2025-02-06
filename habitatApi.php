<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
header('Content-Type: application/json');

// Include action.php file
include_once 'habitatdb.php';
// Create object of Users class
$habitat = new Habitat();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['habitat_id'] ?? '');


// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $habitat->getHabitatById($id);
	} else {
		$data = $habitat->fetchAll();
	}
	echo json_encode($data);
}

// Add a new user into database
if ($api == 'POST') {
	$data = json_decode(file_get_contents('php://input'));
	$name = $habitat->test_input($data->name);
	$description = $habitat->test_input($data->description);
	$habitat_comment = $habitat->test_input($data->habitat_comment);
	if ($habitat->insert($name,  $description, $habitat_comment)) {
		echo $habitat->message('habitat added successfully!', false);
	} else {
		echo $habitat->message('Failed to add an habitat!', true);
	}
}

// Update an user in database
if ($api == 'PUT') {
	$data = $habitat->getHabitatById($id);
	if ($data != null) {
		$data = json_decode(file_get_contents('php://input'));
		$name = $habitat->test_input($data->name);
		$description = $habitat->test_input($data->description);
		$habitat_comment = $habitat->test_input($data->habitat_comment);
		if ($habitat->update($name, $description, $habitat_comment, $id)) {
			http_response_code(202);
			echo $habitat->message('habitat updated successfully!', false);
		} else {
			http_response_code(400);
			echo $habitat->message('Failed to update an habitat!', true);
		}
	} else {
		http_response_code(404);
		echo $habitat->message('habitat not found!', true);
	}
}

// Delete an user from database
if ($api == 'DELETE') {
	$habitat->delete($id);
	if ($id != null) {
		if ($habitat->delete($id)) {

			echo $habitat->message('habitat deleted successfully!', false);
		} else {
			echo $habitat->message('Failed to delete an service!', true);
		}
	} else {
		echo $habitat->message('habitat not found!', true);
	}
}
