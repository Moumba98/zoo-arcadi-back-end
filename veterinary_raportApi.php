<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
include_once 'veterinary_raportdb.php';
// Create object of Users class
$raport = new Raport();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['veterinary_report_id'] ?? '');

// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $raport->getRaportById($id);
	} else {
		$data = $raport->fetchAll();
	}
	echo json_encode($data);
}

// Add a new user into database
if ($api == 'POST') {
	$data = json_decode(file_get_contents('php://input'));
	$date = $raport->test_input($data->Raport);
	$detail = $raport->test_input($data->detail);
	$user_id = $raport->test_input($data->user_id);
	$animal_id = $raport->test_input($data->animal_id);
	if ($raport->insert($date, $detail, $user_id, $animal_id,)) {
		echo $raport->message('veterinary_report added successfully!', false);
	} else {
		echo $raport->message('Failed to add an veterinary_report!', true);
	}
}

// Update an user in database

if ($api == 'PUT') {
	$data = $raport->getRaportById($id);
	if ($data != null) {
		$data = json_decode(file_get_contents('php://input'));
		$date = $raport->test_input($data->date);
		$detail = $raport->test_input($data->detail);
		$user_id = $raport->test_input($data->user_id);
		$animal_id = $raport->test_input($data->animal_id);

		if ($raport->update($date, $detail, $user_id, $animal_id, $id)) {
			echo $raport->message('veterinary_raport added successfully!', false);
		} else {
			echo $raport->message('Failed to add an veterinary_raport!', true);
		}
	} else {

		echo $user->message('veterinary_raport not found!', true);
	}
}

// Delete an user from database
if ($api == 'DELETE') {
	$data = $raport->getRaportById($id);
	if ($data != null) {
		if ($raport->delete($id)) {
			echo $raport->message('veterinary_raport deleted successfully!', false);
		} else {
			echo $raport->message('Failed to delete an veterinary_raport!', true);
		}
	} else {
		echo $raport->message('veterinary_raport not found!', true);
	}
}