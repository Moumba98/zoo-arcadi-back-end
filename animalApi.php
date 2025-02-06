<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
header('Content-Type: application/json');

// Include action.php file
include_once 'animaldb.php';
// Create object of Users class
$animal = new Animal();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['animal_id'] ?? '');

// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $animal->getAnimalById($id);
	} else {
		$data = $animal->fetchAll();
	}
	echo json_encode($data);
}

// Add a new user into database
if ($api == 'POST') {
	$data = json_decode(file_get_contents('php://input'));

	$first_name = $animal->test_input($data->first_name);
	$etat = $animal->test_input($data->etat);
	$race_id = $animal->test_input($data->race_id);
	$habitat_id = $animal->test_input($data->habitat_id);

	if ($animal->insert($first_name, $etat, $race_id, $habitat_id)) {
		echo $animal->message('Animal added successfully!', false);
	} else {
		echo $animal->message('Failed to add an Animal!', true);
	}
}

// Update an user in database

if ($api == 'PUT') {
	$data = $animal->getAnimalById($id);
	if ($data != null) {
		$data = json_decode(file_get_contents('php://input'));
		$first_name = $animal->test_input($data->first_name);
		$etat = $animal->test_input($data->etat);
		$race_id = $animal->test_input($data->race_id);
		$habitat_id = $animal->test_input($data->habitat_id);

		if ($animal->update($first_name, $etat, $race_id, $habitat_id, $id)) {
			echo $animal->message('Animal added successfully!', false);
		} else {
			echo $animal->message('Failed to add an Animal!', true);
		}
	} else {

		echo $animal->message('Animal not found!', true);
	}
}

// Delete an user from database
if ($api == 'DELETE') {
	$data = $animal->getAnimalById($id);
	if ($data != null) {
		if ($animal->delete($id)) {
			echo $animal->message('Animal deleted successfully!', false);
		} else {
			echo $animal->message('Failed to delete an Animal!', true);
		}
	} else {
		echo $user->message('Animal not found!', true);
	}
}