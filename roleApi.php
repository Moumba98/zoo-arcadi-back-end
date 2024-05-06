<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
include_once 'roledb.php';
// Create object of Users class
$role = new Role();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['role_id'] ?? '');

// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $role->getRoleById($id);
	} else {
		$data = $role->fetchAll();
	}
	echo json_encode($data);
}

// Add a new user into database
if ($api == 'POST') {
	$data = json_decode(file_get_contents('php://input'));
	$label = $role->test_input($data->label);
	if ($role->insert($label)) {
		echo $role->message('role added successfully!', false);
	} else {
		echo $role->message('Failed to add an service!', true);
	}
}

// Update an user in database

if ($api == 'PUT') {
	$data = $role->getRoleById($id);
 if ($data != null) {
   $data = json_decode(file_get_contents('php://input'));
   $label = $role->test_input($data->label);
   
   if ($role->update($label , $id)) {
	   http_response_code(202);
	 echo $role->message('User updated successfully!', false);
   } else {
	   http_response_code(400);
	 echo $role->message('Failed to update an user!', true);
   }
 } else {
   http_response_code(404);
   echo $role->message('User not found!', true);
 }
}

// Delete an role from database
if ($api == 'DELETE') {
	$role->delete($id);
	if ($id != null) {
		if ($role->delete($id)) {

			echo $role->message('role deleted successfully!', false);
		} else {
			echo $role->message('Failed to delete an role!', true);
		}
	} else {
		echo $role->message('role not found!', true);
	}
}
