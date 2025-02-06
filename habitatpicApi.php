<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
header('Content-Type: application/json');

// Include action.php file
include_once 'habitatpicdb.php';
// Create object of Users class
$habitatpic = new Habitatpic();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['habitat_picture_id'] ?? '');




// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $habitatpic->getHabitatpicById($id);
       
	} else {
		$data = $habitatpic->fetchAll();
	}
	echo json_encode($data);
}

// Add a new user into database
if ($api == 'POST') {
	$data = json_decode(file_get_contents('php://input'));
	$habitat_id = $habitatpic->test_input($data->habitat_id);
	$picture_id = $habitatpic->test_input($data->picture_id);
	if ($habitatpic->insert($habitat_id,  $picture_id)) {
		echo $habitatpic->message('habitat_picture added successfully!', false);
	} else {
		echo $habitatpic->message('Failed to add an habitat_picture!', true);
	}
}

// Update an user in database
if ($api == 'PUT') {
	$data = $habitatpic->getHabitatpicById($id);
	if ($data != null) {
		$data = json_decode(file_get_contents('php://input'));
		$habitat_id = $habitatpic->test_input($data->habitat_id);
        var_dump($habitat_id);
	    $picture_id = $habitatpic->test_input($data->picture_id);
        var_dump($picture_id);
        
		if ($habitatpic->update($habitat_id, $picture_id, $id)) {
			http_response_code(202);
			echo $habitatpic->message('habitat_picture updated successfully!', false);
		} else {
			http_response_code(400);
			echo $habitatpic->message('Failed to update an habitat_picture!', true);
		}
	} else {
		http_response_code(404);
		echo $habitatpic->message('habitat_picture not found!', true);
	}
}

// Delete an user from database
if ($api == 'DELETE') {
	$habitatpic->delete($id);
	if ($id != null) {
		if ($habitatpic->delete($id)) {
			echo $habitatpic->message('habitat_picture deleted successfully!', false);
		} else {
			echo $habitatpic->message('Failed to delete an service!', true);
		}
	} else {
		echo $habitatpic->message('habitat_picture not found!', true);
	}
}
