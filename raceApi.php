<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
include_once 'racedb.php';
// Create object of Users class
$race = new Race();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['race_id'] ?? '');

// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $race->getRaceById($id);
	} else {
		$data = $race->fetchAll();
	}
	echo json_encode($data);
}

// Add a new user into database
if ($api == 'POST') {
	$data = json_decode(file_get_contents('php://input'));
	$label = $race->test_input($data->label);
	if ($race->insert($label)) {
		echo $race->message('race added successfully!', false);
	} else {
		echo $role->message('Failed to add an race!', true);
	}
}

// Update an user in database

if ($api == 'PUT') {
	$data = $race->getRaceById($id);
	if ($data != null) {
		$data = json_decode(file_get_contents('php://input'));
		$label = $race->test_input($data->label);

		if ($race->update($label, $id)) {
			http_response_code(202);
			echo $race->message('race updated successfully!', false);
		} else {
			http_response_code(400);
			echo $race->message('Failed to update an race!', true);
		}
	} else {
		http_response_code(404);
		echo $race->message('race not found!', true);
	}
}

// Delete an role from database
if ($api == 'DELETE') {
	$race->delete($id);
	if ($id != null) {
		if ($race->delete($id)) {

			echo $race->message('race deleted successfully!', false);
		} else {
			echo $race->message('Failed to delete an race!', true);
		}
	} else {
		echo $race->message('race not found!', true);
	}
}
